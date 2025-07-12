<?php

$root = "storage";
$file= 'one/two/three/test.txt';
$content = 'hello world';

$savePath = "{$root}/{$file}";
mkdir(dirname($savePath), 0777, recursive:true);

file_put_contents($savePath, $content);