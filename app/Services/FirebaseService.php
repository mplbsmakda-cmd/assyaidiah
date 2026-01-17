<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Storage\ObjectNotFound;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $storage;
    protected $bucket;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri(sprintf('https://%s.firebaseio.com', config('firebase.project_id')));

        $this->storage = $factory->createStorage();
        $this->bucket = $this->storage->getBucket(config('firebase.storage_bucket'));
    }

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
     *
     * @param string|null $url
     * @return void
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
     *
     * @param string $url
     * @return string|null
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
