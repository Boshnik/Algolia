<?php

namespace Boshnik\Algolia\Events;

class pbOnAfterDuplicate extends Event
{
    public function run()
    {
        if ($this->scriptProperties['type'] === $this->algolia->config['classKey']) {
            $newResource = $this->scriptProperties['newObject'] ?? null;
            if ($newResource && $this->algolia->validateObject($newResource)) {
                $this->algolia->addRecord($this->algolia->getObjectValues($newResource));
            }
        }
    }
}