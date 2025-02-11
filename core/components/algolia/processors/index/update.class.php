<?php

class AlgoliaUpdateIndexProcessor extends modProcessor
{
    public function process()
    {
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $algolia = $this->modx->services->get('algolia');
        } else {
            $algolia = $this->modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/');
        }

        $records = $algolia->getRecords();

        $algolia->addRecords($records);
        $algolia->setSettings([
            'searchableAttributes' => explode(',', $algolia->config['searchableFields']),
            'attributesToRetrieve' => explode(',', $algolia->config['fieldsToRetrieve']),
            'highlightPreTag' => '<em>',
            'highlightPostTag' => '</em>',
        ]);

        $this->modx->error->total = count($records);

        return $this->success('', $records);
    }

}

return 'AlgoliaUpdateIndexProcessor';