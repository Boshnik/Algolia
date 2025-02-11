<?php

namespace Boshnik\Algolia\Events;

class OnResourceDelete extends Event
{
    public function run()
    {
        $resource = $this->scriptProperties['resource'] ?? null;
        if (!$resource) {
            return;
        }

        $this->algolia->deleteRecord($resource->id);
    }
}