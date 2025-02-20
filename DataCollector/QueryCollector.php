<?php
namespace Fruitcake\MagentoDebugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Fruitcake\MagentoDebugbar\DataFormatter\SimpleFormatter;
use Fruitcake\MagentoDebugbar\Profiler\QueryProfiler;
use Magento\Framework\App\ObjectManager;

class QueryCollector extends PDOCollector
{
    protected $resourceConnection;
    protected $durationBackground = true;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection, TimeDataCollector $timeDataCollector)
    {
        $this->resourceConnection = $resourceConnection;

        parent::__construct(null, $timeDataCollector);
    }

    /**
     * @return array
     */
    public function collect()
    {
        /** @var \Zend_Db_Profiler $profiler */
        $profiler = $this->resourceConnection->getConnection()->getProfiler();

        $stmts = [];

        /** @var \Zend_Db_Profiler_Query $profile */
        foreach ($profiler->getQueryProfiles() as $queryId => $profile) {

            if ($profiler instanceof QueryProfiler) {
                $backtrace = $profiler->getBacktrace($queryId);
            } else {
                $backtrace = null;
            }

            $source = $backtrace ? reset($backtrace) : null;
            $stmts[] = [
                'duration' => $profile->getElapsedSecs(),
                'duration_str' => ($profile->getQueryType() == \Zend_Db_Profiler::TRANSACTION) ? '' : $this->formatDuration($profile->getElapsedSecs()),
                'sql' => $profile->getQuery(),
                'backtrace' => $backtrace ? array_values($backtrace) : null,
                'xdebug_link' => ($source && is_object($source)) ? $this->getXdebugLink($source->file ?: '', $source->line) : null,
            ];

            if ($this->timeCollector !== null) {
                $this->timeCollector->addMeasure(str_replace("\n", '', $profile->getQuery()), $profile->getStartedMicrotime(), $profile->getStartedMicrotime() + $profile->getElapsedSecs(), array(), 'database', 'database');
            }
        }

        $totalTime = $profiler->getTotalElapsedSecs();

        if ($this->durationBackground && $totalTime > 0) {
            $start_percent = 0;
            foreach ($stmts as $i => $stmt) {
                if (!isset($stmt['duration'])) {
                    continue;
                }

                $width_percent = $stmt['duration'] / $totalTime * 100;
                $stmts[$i] = array_merge($stmt, [
                    'start_percent' => round($start_percent, 3),
                    'width_percent' => round($width_percent, 3),
                ]);
                $start_percent += $width_percent;
            }
        }

        return array(
            'nb_statements' => $profiler->getTotalNumQueries(),
            'nb_failed_statements' => 0,
            'accumulated_duration' => $profiler->getTotalElapsedSecs(),
            'accumulated_duration_str' => $this->formatDuration($profiler->getTotalElapsedSecs()),
            'memory_usage' => null,
            'memory_usage_str' => '',
            'peak_memory_usage' => null,
            'peak_memory_usage_str' => '',
            'statements' => array_values($stmts)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'queries';
    }

    /**
     * @return array
     */
    public function getWidgets()
    {
        return array(
            "database" => array(
                "icon" => "database",
                "widget" => "PhpDebugBar.Widgets.SQLQueriesWidget",
                "map" => "queries",
                "default" => "[]"
            ),
            "database:badge" => array(
                "map" => "queries.nb_statements",
                "default" => 0
            )
        );
    }
}
