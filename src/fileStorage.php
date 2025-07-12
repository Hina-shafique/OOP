<?php 

namespace App;

interface FileStorage
{
    public function put(string $file, string $content):void;
}