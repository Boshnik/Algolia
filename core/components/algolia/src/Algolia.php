<?php

namespace Boshnik\Algolia;

use Boshnik\Algolia\Traits\AlgoliaTrait;
use Boshnik\Algolia\Traits\ResourceTrait;

class Algolia
{
    use AlgoliaTrait;
    use ResourceTrait;

    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(public &$modx, public array $config = [])
    {
        $basePath = "components/algolia/";
        $corePath = MODX_CORE_PATH . $basePath;
        $assetsUrl = MODX_ASSETS_URL . $basePath;

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl . 'connector.php',

            'debug' => (bool)$this->getOption('debug', false),

            'appID' => $this->getOption('app_id'),
            'apiKey' => $this->getOption('api_key'),
            'indexName' => $this->getOption('index_name'),
            'searchableFields' => $this->getOption('searchable_fields', 'pagetitle'),
            'fieldsToRetrieve' => $this->getOption('fields_to_retrieve', 'pagetitle'),

            'fields' => $this->getOption('fields', 'pagetitle'),
            'classKey' => $this->getOption('class_key', 'modDocument'),
            'where' => $this->getOption('where'),
        ], $config);

        $this->modx->lexicon->load("algolia:default");
    }

    /**
     * Gets the MODX system setting value.
     *
     * @param string $key The key of the system setting.
     * @param string $default The default value if the setting is not found.
     *
     * @return string Value of the customization.
     */
    public function getOption($key, $default = ''): string
    {
        $option = trim($this->modx->getOption("algolia.$key", null, $default, true));
        if ($key === 'class_key' && $option === 'modDocument' && $this->modx->getVersionData()['version'] === '3') {
            $option = 'MODX\Revolution\modDocument';
        }

        return $option;
    }

    /**
     * Writes a message to the MODX log.
     *
     * @param string $message Message to be logged.
     * @param int $level Logging level (1 = INFO, 2 = WARNING, 3 = ERROR).
     * @param string $filename Log file name.
     *
     * @return void
     */
    public function log($message, $level = 1, $filename = 'algolia.log'): void
    {
        $old = $this->modx->setLogLevel($level);
        $this->modx->log($level, '[Algolia] ' . $message, ['target' => 'FILE', 'options' => ['filename' => $filename]]);
        $this->modx->setLogLevel($old);
    }

    /**
     * Starts the MODX processor.
     *
     * @param string $action The name of the processor.
     * @param array $data Array of data to pass to the processor.
     *
     * @return mixed The result of the processor.
     */
    public function runProcessor($action = '', $data = []): mixed
    {
        if (empty($action)) {
            return false;
        }
        $this->modx->error->reset();
        $processorsPath = !empty($this->config['processorsPath'])
            ? $this->config['processorsPath']
            : MODX_CORE_PATH . 'components/algolia/processors/';

        return $this->modx->runProcessor($action, $data, array(
            'processors_path' => $processorsPath,
        ));
    }

    /**
     * @param $page
     * @return string
     */
    public function buildPaginationLink($page): string
    {
        $params = $_GET;
        unset($params['q']);
        $params['page'] = $page;

        return $this->modx->makeUrl($this->modx->resource->id ?? 1, '', $params, -1);
    }

}