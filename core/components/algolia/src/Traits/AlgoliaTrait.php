<?php

namespace Boshnik\Algolia\Traits;

use Algolia\AlgoliaSearch\Api\SearchClient;

trait AlgoliaTrait
{
    /**
     * Returns an instance of the Algolia client to interact with the API.
     *
     * @return SearchClient|bool SearchClient object on success, false on error.
     */
    public function getClient(): bool|SearchClient
    {
        if (empty($this->config['appID']) || empty($this->config['apiKey'])) {
            $this->log('Algolia appID or API key not configured');
            return false;
        }

        if (empty($this->config['indexName'])) {
            $this->log('Algolia index name not configured.');
            return false;
        }

        try {
            return SearchClient::create($this->config['appID'], $this->config['apiKey']);
        } catch (\Exception $e) {
            $this->log('Error initializing Algolia client: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sets the settings for the Algolia index.
     *
     * @param array $settings
     *
     * @return array|bool  The Algolia response, or FALSE on failure.
     */
    public function setSettings(array $settings = []): bool|array
    {
        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->setSettings($this->config['indexName'], $settings);

            if ($this->config['debug']) {
                $this->log( 'Settings saved to ' . $this->config['indexName'] . 'Settings: ' . print_r($settings, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log( 'Error saved settings ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add a single record to Algolia.
     *
     * @param array $data The data to be indexed.  Must contain an 'objectID' key.
     *
     * @return array|bool  The Algolia response, or FALSE on failure.
     */
    public function addRecord(array $data): bool|array
    {
        if (empty($data['objectID'])) {
            $this->log( 'Cannot add record: objectID is required.');
            return false;
        }

        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->saveObject($this->config['indexName'], $data);

            if ($this->config['debug']) {
                $this->log('Added record ' . $data['objectID'] . ' to Algolia. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log('Error adding record to Algolia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a record from Algolia.
     *
     * @param string $objectID The objectID of the record to delete.
     *
     * @return array|bool The Algolia response, or FALSE on failure.
     */
    public function deleteRecord(string $objectID): bool|array
    {
        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->deleteObject($this->config['indexName'], $objectID);

            if ($this->config['debug']) {
                $this->log( 'Deleted record ' . $objectID . ' from Algolia. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log( 'Error deleting record from Algolia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing record in Algolia.  Requires that the 'objectID' already exists.
     *
     * @param array $data The data to update.  Must contain an 'objectID' key.
     *
     * @return array|bool The Algolia response, or FALSE on failure.
     */
    public function updateRecord(array $data): bool|array
    {
        if (empty($data['objectID'])) {
            $this->log( 'Cannot update record: objectID is required.');
            return false;
        }

        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->partialUpdateObject($this->config['indexName'], $data);

            if ($this->config['debug']) {
                $this->log( 'Updated record ' . $data['objectID'] . ' in Algolia. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log('Error updating record in Algolia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a single record from Algolia by its objectID.
     *
     * @param string $objectID The objectID of the record to retrieve.
     *
     * @return array|bool The Algolia response, or FALSE on failure.
     */
    public function getRecord(string $objectID): bool|array
    {
        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->getObject($this->config['indexName'], $objectID);

            if ($this->config['debug']) {
                $this->log('Retrieved record ' . $objectID . ' from Algolia. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log( 'Error getting record from Algolia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add multiple records to Algolia.
     *
     * @param array $records An array of data arrays to be indexed. Each array must contain an 'objectID' key.
     *
     * @return array|bool The Algolia response, or FALSE on failure.
     */
    public function addRecords(array $records): bool|array
    {
        if (empty($records)) {
            $this->log( 'No records to add.');
            return true;
        }

        // Validate objectIDs
        foreach ($records as $record) {
            if (empty($record['objectID'])) {
                $this->log('Cannot add records: objectID is required in each record.');
                return false;
            }
        }

        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->saveObjects($this->config['indexName'], $records);

            if ($this->config['debug']) {
                $this->log('Added ' . count($records) . ' records to Algolia. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log( 'Error adding records to Algolia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete all records from the Algolia index.
     *
     * @return array|bool The Algolia response, or FALSE on failure.
     */
    public function clearIndex(): bool|array
    {
        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->clearObjects($this->config['indexName']);

            if ($this->config['debug']) {
                $this->log('Cleared all records from Algolia index. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log( 'Error clearing Algolia index: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Search the Algolia index.
     *
     * @param string $query The search query.
     * @param array $params Optional search parameters.
     *
     * @return array|bool The Algolia search results, or FALSE on failure.
     */
    public function search(string $query, array $params = []): bool|array
    {
        if (!$client = $this->getClient()) {
            return false;
        }

        try {
            $response = $client->search([
                'requests' => [
                    array_merge([
                        'indexName' => $this->config['indexName'],
                        'query' => $query,
                        'hitsPerPage' => 50,
                    ], $params),
                ],
            ]);

            if ($this->config['debug']) {
                $this->log('Search query: ' . $query . ', params: ' . print_r($params, true) . '. Response: ' . print_r($response, true));
            }

            return $response;
        } catch (\Exception $e) {
            $this->log('Error searching Algolia: ' . $e->getMessage());
            return false;
        }
    }
}