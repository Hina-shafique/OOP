<?php
use Aws\S3\S3Client;
require 'vendor/autoload.php';

$s3key = '';
$s3secret = '';

$file= 'test.txt';
$content = 'hello world';
$bucket = 'laracast-testing';

