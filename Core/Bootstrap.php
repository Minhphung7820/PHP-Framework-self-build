<?php

namespace Core;

use DirectoryIterator;

class Bootstrap
{
    public function __construct()
    {
        // Khai báo helpers;
        $folderPath = './Helpers';
        $directoryIterator = new DirectoryIterator($folderPath);
        foreach ($directoryIterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                require $folderPath . "/" . $fileInfo->getFilename();
            }
        }
    }
}
