<?php
/**
 * Algolia connector
 *
 * @var modX $modx
 */

require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

/** @var Algolia $algolia */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $algolia = $modx->services->get('algolia');
} else {
    $algolia = $modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/');
}

// Handle request
$modx->request->handleRequest([
    'processors_path' => $algolia->config['processorsPath'],
    'location' => ''
]);