<?php

namespace Boshnik\Algolia\Events;

class OnDocFormSave extends Event
{
    public function run()
    {
        $resource = $this->scriptProperties['resource'] ?? null;
        if (!$resource) {
            return;
        }

        if ($this->algolia->validateObject($resource)) {
            $this->algolia->addRecord($this->algolia->getObjectValues($resource));
        } else {
            $this->algolia->deleteRecord($resource->id);
        }
    }
}