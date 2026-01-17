<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Exception\Storage\ObjectNotFound;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $storage;
    protected $bucket;
    protected Firestore $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri(sprintf('https://%s.firebaseio.com', config('firebase.project_id')));

        $this->storage = $factory->createStorage();
        $this->firestore = $factory->createFirestore();
        $this->bucket = $this->storage->getBucket(config('firebase.storage_bucket'));
    }

    //======================================================================
    // Firestore Methods
    //======================================================================

    /**
     * Get all documents from a Firestore collection.
     */
    public function getCollection(string $collectionName): array
    {
        $collection = $this->firestore->collection($collectionName);
        $documents = $collection->documents();
        $results = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $results[] = array_merge(['id' => $document->id()], $document->data());
            }
        }
        return $results;
    }

    /**
     * Get a specific document from a Firestore collection by its ID.
     */
    public function getDocument(string $collectionName, string $documentId): ?array
    {
        $document = $this->firestore->collection($collectionName)->document($documentId)->snapshot();
        if ($document->exists()) {
            return array_merge(['id' => $document->id()], $document->data());
        }
        return null;
    }

    /**
     * Add a new document to a Firestore collection.
     */
    public function addDocument(string $collectionName, array $data): string
    {
        $document = $this->firestore->collection($collectionName)->add($data);
        return $document->id();
    }

    /**
     * Update an existing document in a Firestore collection.
     */
    public function updateDocument(string $collectionName, string $documentId, array $data): void
    {
        $this->firestore->collection($collectionName)->document($documentId)->set($data, ['merge' => true]);
    }

    /**
     * Delete a document from a Firestore collection.
     */
    public function deleteDocument(string $collectionName, string $documentId): void
    {
        $this->firestore->collection($collectionName)->document($documentId)->delete();
    }


    //======================================================================
    // Storage Methods
    //======================================================================

    public function upload($file, $path)
    {
        $object = $this->bucket->upload(
            fopen($file->getRealPath(), 'r'),
            [
                'name' => $path,
                'predefinedAcl' => 'publicRead'
            ]
        );

        return $object->info()['mediaLink'];
    }

    /**
     * Delete an object from Firebase Storage by its URL.
     */
    public function delete(?string $url): void
    {
        if (!$url) {
            return;
        }

        try {
            $objectPath = $this->getPathFromUrl($url);

            if ($objectPath) {
                $object = $this->bucket->object($objectPath);
                if ($object->exists()) {
                    $object->delete();
                }
            }
        } catch (ObjectNotFound $e) {
            Log::info('FirebaseService: Tried to delete an object that was not found.', ['url' => $url]);
        } catch (\Exception $e) {
            Log::error('FirebaseService: Error deleting object.', ['error' => $e->getMessage(), 'url' => $url]);
        }
    }

    /**
     * Extracts the object path from a Firebase Storage mediaLink URL.
     */
    private function getPathFromUrl(string $url): ?string
    {
        $bucketName = config('firebase.storage_bucket');
        $prefix = "https://storage.googleapis.com/download/storage/v1/b/{$bucketName}/o/";

        if (strpos($url, $prefix) !== 0) {
            Log::warning('FirebaseService: URL format for deletion is not the expected mediaLink format.', [
                'url' => $url,
                'expected_prefix' => $prefix
            ]);
            return null;
        }
        
        $pathWithQuery = substr($url, strlen($prefix));
        $encodedPath = strtok($pathWithQuery, '?'); // Remove query string

        return $encodedPath ? urldecode($encodedPath) : null;
    }
}
