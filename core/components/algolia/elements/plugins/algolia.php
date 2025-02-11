<?php
/**
 * Algolia
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

/** @var Algolia $algolia */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $algolia = $modx->services->get('algolia');
} else {
    $algolia = $modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/');
}

$className = 'Boshnik\Algolia\Events\\' . $modx->event->name;
if (class_exists($className)) {
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}