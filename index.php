<?php

use App\Storage;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Storage::resolve()->put('test.txt', 'hello world');

echo 'done';