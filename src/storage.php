<?php

namespace App;
use Exception;
class Storage
{
    public static function resolve(): FileStorage
    {
        $storageType = $_ENV['file_storage'];

        if ($storageType === 'local') {
            return new localStorage();
        } elseif ($storageType === 's3') {
            $client = new S3Client([
                'version' => 'latest',
                'region' => 'us-west-2',
                'credentials' => [
                    'key' => $_ENV['s3_KEY'],
                    'secret' => $_ENV['s3_SECRET'],
                ],
            ]);

            return new s3Storage($client, $_ENV['s3_BUCKET']);
        }
        throw new Exception("Unsupported storage type: {$storageType}");
    }

}