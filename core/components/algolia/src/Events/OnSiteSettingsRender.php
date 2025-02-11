<?php

namespace Boshnik\Algolia\Events;

class OnSiteSettingsRender extends Event
{
    public function run()
    {
        $this->modx->controller->addJavascript($this->algolia->config['assetsUrl'] . 'modx.combo.js');
    }
}