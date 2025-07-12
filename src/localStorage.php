<?php

namespace App;

class localStorage implements FileStorage
{
    public function put(string $file, string $content): void
    {
        $root = __DIR__ . '/../storage';
        $savePath = "{$root}/{$file}";

        if (!is_dir(dirname($savePath))) {
            mkdir(dirname($savePath), 0777, true);
        }

        file_put_contents($savePath, $content);
    }
}