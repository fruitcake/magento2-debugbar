<?php

namespace Fruitcake\MagentoDebugbar\Profiler;

use Magento\Framework\App\ObjectManager;

class QueryProfiler extends \Zend_Db_Profiler
{
    protected $backtraces;
    protected $backtraceExcludePaths = [
        '/vendor/magento/zend-db/',
        '/vendor/magento/framework/',
        '/generated/code/Magento/Framework/',
        '/generated/code/Magento/Eav/',
        '/generated/code/Magento/Config/Model/ResourceModel',
        '/vendor/magento/framework/Data/',
        '/generated/code/Magento/Customer/Model/ResourceModel/',
        __DIR__,
    ];
    protected $basePath = null;

    public function queryStart($queryText, $queryType = null)
    {
        $queryId = parent::queryStart($queryText, $queryType);

        $this->backtraces[$queryId] = $this->findSource();

        return $queryId;
    }

    public function getBacktrace($queryId)
    {
        return $this->backtraces[$queryId] ?? null;
    }

    /**
     * Use a backtrace to search for the origins of the query.
     *
     * @return array
     */
    protected function findSource()
    {
        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, 50);

        $sources = [];

        foreach ($stack as $index => $trace) {
            $sources[] = $this->parseTrace($index, $trace);
        }

        return array_slice(array_filter($sources), 0, 5);
    }

    /**
     * Parse a trace element from the backtrace stack.
     *
     * @param  int    $index
     * @param  array  $trace
     * @return object|bool
     */
    protected function parseTrace($index, array $trace)
    {
        $frame = (object) [
            'index' => $index,
            'namespace' => null,
            'name' => null,
            'file' => null,
            'line' => $trace['line'] ?? '1',
        ];

        if (
            isset($trace['class']) &&
            isset($trace['file']) &&
            !$this->fileIsInExcludedPath($trace['file'])
        ) {
            $frame->file = $trace['file'];
            $frame->name = $this->normalizeFilePath($frame->file);

            return $frame;
        }


        return false;
    }

    /**
     * TODO; check base path
     * @param $path
     * @return string
     */
    protected function normalizeFilePath($path)
    {
        $this->basePath = $this->basePath ?? ObjectManager::getInstance()->get(\Magento\Framework\Filesystem\DirectoryList::class)->getRoot();
        return str_replace($this->basePath, '', $path);
    }

    /**
     * Check if the given file is to be excluded from analysis
     *
     * @param string $file
     * @return bool
     */
    protected function fileIsInExcludedPath($file)
    {
        $normalizedPath = str_replace('\\', '/', $file);

        foreach ($this->backtraceExcludePaths as $excludedPath) {
            if (strpos($normalizedPath, $excludedPath) !== false) {
                return true;
            }
        }

        return false;
    }

}
