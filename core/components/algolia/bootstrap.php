<?php
/** @var MODX\Revolution\modX $modx */

require_once MODX_CORE_PATH . 'components/algolia/vendor/autoload.php';

$modx->services['algolia'] = $modx->services->factory(function($c) use ($modx) {
    return new Boshnik\Algolia\Algolia($modx);
});