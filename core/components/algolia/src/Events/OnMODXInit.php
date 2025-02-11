<?php

namespace Boshnik\Algolia\Events;

class OnMODXInit extends Event
{
    public function run()
    {
        if ($this->modx->context->key === 'mgr') {
            $this->modx->regClientStartupScript('<script>
                Ext.onReady(() => {
                    window.Algolia = {};
                    Algolia.config = ' . json_encode($this->algolia->config) . ';
                });
            </script>');
        }
    }
}