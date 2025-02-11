<?php

namespace Boshnik\Algolia\Events;

abstract class Event
{
    /** @var \Boshnik\Algolia\Algolia $algolia */
    protected \Boshnik\Algolia\Algolia $algolia;

    public function __construct(public \modX $modx, protected array $scriptProperties)
    {
        if ($this->modx->services instanceof \MODX\Revolution\Services\Container) {
            $this->algolia = $this->modx->services->get('algolia');
        } else {
            $this->algolia = $this->modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/');
        }
    }

    abstract public function run();
}