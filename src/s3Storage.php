<?php

namespace App;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
class s3Storage implements FileStorage
{

    public function __construct(protected S3Client $client, protected string $bucket)
    {
        //
    }
    public function put(string $file, string $content): void
    {
        try {
            $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $file,
                'Body' => $content,
            ]);
        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }
}