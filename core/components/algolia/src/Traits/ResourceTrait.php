<?php

namespace Boshnik\Algolia\Traits;

trait ResourceTrait
{
    public string $resourceClassKey = \modResource::class;

    public function getRecords(): array
    {
        $query = $this->modx->newQuery($this->resourceClassKey);
        if ($this->config['classKey'] === 'msProduct') {
            $query->leftJoin('msProductData', 'msProductData', 'msProductData.id = modResource.id');
        }

        $query->where($this->getWhere());
        $query->select($this->getFields());
        $query->prepare();
        $query->stmt->execute();
        $data = $query->stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        if ($this->config['classKey'] === 'pbResource') {
            foreach ($data as &$item) {
                if (!empty($item['values'])) {
                    $values = is_string($item['values'])
                        ? (json_decode($item['values'], true) ?: [])
                        : [];
                    if (is_array($values)) {
                        foreach ($values as $key => $value) {
                            $item[$key] = $value;
                        }
                    }
                    unset($item['values']);
                }
            }
        }
        if ($this->config['debug']) {
            $this->log('Records SQL: ' . $query->toSQL());
            $this->log('Records: ' . print_r($data, true));
        }

        return $data;
    }

    public function getWhere(array $where = []): array
    {
        $where = array_merge([
            'class_key' => $this->config['classKey'],
            'published' => 1,
            'searchable' => 1,
            'deleted' => 0,
        ], $where);

        $addWhere = $this->config['where'] ?? [];
        if (is_string($addWhere)) {
            $addWhere = json_decode($addWhere, true)[0] ?? [];
        }
        $where = array_merge($where, $addWhere);

        if ($where['class_key'] === 'msProduct') {
            $columns = $this->getTableColumns();
            $where = array_combine(
                array_map(fn($key) => in_array($key, $columns) ? 'modResource.' . $key : 'msProductData.' . $key,
                    array_keys($where)),
                array_values($where)
            );
        }

        return $where;
    }

    public function getFields(): array
    {
        $fields = explode(',', $this->config['fields']);
        $columns = $this->getTableColumns();

        if ($this->config['classKey'] === 'msProduct') {
            $fields = array_map(
                fn($item) => in_array($item, $columns) ? 'modResource.' . $item : 'msProductData.' . $item,
                $fields
            );
            return array_merge(['modResource.id AS objectID'], $fields);
        }

        if ($this->config['classKey'] === 'pbResource') {
            $fields[] = 'values';
        }

        return array_merge(['id AS objectID'], array_intersect($fields, $columns));
    }

    public function getObjectValues($object): array
    {
        $array = $object->toArray();
        $fields = explode(',', $this->config['fields']);
        $data = array_intersect_key($array, array_flip($fields));
        $data['objectID'] = $object->id;

        return $data;
    }

    public function validateObject($object): bool
    {
        $where = $this->getWhere(['id' => $object->id]);

        return $this->modx->getCount($this->resourceClassKey, $where);
    }

    public function getTableColumns(): array
    {
        $tableName = $this->modx->getTableName($this->resourceClassKey);
        $q = $this->modx->prepare("DESCRIBE " . $tableName);
        $q->execute();
        return $q->fetchAll(\PDO::FETCH_COLUMN) ?? [];
    }
}