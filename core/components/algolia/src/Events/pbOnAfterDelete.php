<?php

namespace Boshnik\Algolia\Events;

class pbOnAfterDelete extends Event
{
    public function run()
    {
        if ($this->scriptProperties['type'] === $this->algolia->config['classKey']) {
            $this->algolia->deleteRecord($this->scriptProperties['id'] ?? 0);
        }
    }
}