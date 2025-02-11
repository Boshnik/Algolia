<?php

namespace Boshnik\Algolia\Events;

class OnResourceDuplicate extends Event
{
    public function run()
    {
        $newResource = $this->scriptProperties['newResource'] ?? null;
        if (!$newResource) {
            return;
        }

        if ($this->algolia->validateObject($newResource)) {
            $this->algolia->addRecord($this->algolia->getObjectValues($newResource));
        }
    }
}