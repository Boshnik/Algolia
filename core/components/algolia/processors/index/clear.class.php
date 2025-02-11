<?php

class AlgoliaClearIndexProcessor extends modProcessor
{
    public function process()
    {
        /** @var Algolia $algolia */
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $algolia = $this->modx->services->get('algolia');
        } else {
            $algolia = $this->modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/');
        }

        if (!$algolia->clearIndex()) {
            return $this->failure('Failed to clear index.');
        }

        return $this->success('Index cleared.');
    }

}

return 'AlgoliaClearIndexProcessor';