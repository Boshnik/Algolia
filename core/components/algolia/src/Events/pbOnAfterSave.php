<?php

namespace Boshnik\Algolia\Events;

class pbOnAfterSave extends Event
{
    public function run()
    {
        if ($this->scriptProperties['type'] === $this->algolia->config['classKey']) {
            $resource = $this->scriptProperties['object'] ?? null;
            if (!$resource) {
                return false;
            }

            if ($this->algolia->validateObject($resource)) {
                $this->algolia->addRecord($this->algolia->getObjectValues($resource));
            } else {
                $this->algolia->deleteRecord($this->scriptProperties['id'] ?? 0);
            }
        }
    }
}