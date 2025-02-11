<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var Algolia $algolia */

$algolia = $modx->services instanceof MODX\Revolution\Services\Container
    ? $modx->services->get('algolia')
    : $modx->getService('algolia', 'Algolia', MODX_CORE_PATH . 'components/algolia/model/', $scriptProperties);

if (!$algolia) {
    return 'Could not load Algolia class!';
}

$options = array_merge([
    'paramSearch' => 'query',
    'tpl' => 'algolia.result',
    'tpl.result.item' => 'algolia.result.item',
    'tpl.result.empty' => 'algolia.result.empty',
    'tpl.pagination' => 'algolia.pagination',
    'tpl.pagination.item' => 'algolia.pagination.item',
    'limit' => 10,
    'outputSeparator' => "\n",
    'toPlaceholder' => false
], $scriptProperties);

$searchQuery = $_REQUEST[$options['paramSearch']] ?? '';
if (empty($searchQuery)) {
    return $modx->getChunk($options['tpl.result.empty']);
}

$currentPage = max(1, (int) ($_REQUEST['page'] ?? 1));
$response = $algolia->search($searchQuery, [
    'hitsPerPage' => $options['limit'],
    'page' => $currentPage - 1
]);

$results = $response['results'][0] ?? [];
$total = $results['nbHits'] ?? 0;
$items = $results['hits'] ?? [];
$pages = max(1, ceil($total / $options['limit']));

if ($pages > 1) {
    $links = array_map(fn($i) => $modx->getChunk($options['tpl.pagination.item'], [
        'page' => $i,
        'current' => $currentPage,
        'link' => $algolia->buildPaginationLink($i),
    ]), range(1, $pages));

    $pagination = $modx->getChunk($options['tpl.pagination'], [
        'page' => $currentPage,
        'last' => $pages,
        'links' => implode('', $links),
        'prev' => $algolia->buildPaginationLink(max($currentPage - 1, 1)),
        'next' => $algolia->buildPaginationLink(min($currentPage + 1, $pages)),
        'total' => $total
    ]);
}

$result = implode($options['outputSeparator'], array_map(fn($item) =>
$modx->getChunk($options['tpl.result.item'], array_merge($item, ['id' => $item['objectID']])), $items));

$output = $modx->getChunk($options['tpl'], [
    'total' => $total,
    'result' => $result,
    'pagination' => $pagination ?? '',
]);

if (!empty($options['toPlaceholder'])) {
    $modx->setPlaceholder($options['toPlaceholder'], $output);
    return '';
}

return $output;