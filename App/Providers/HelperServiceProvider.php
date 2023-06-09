<?php

namespace App\Providers;

use App\Providers\BaseServiceProvider;
use DirectoryIterator;

class HelperServiceProvider implements BaseServiceProvider
{
    public function register()
    {
    }
    public function boot()
    {
        $folderPath = './Helpers';
        $directoryIterator = new DirectoryIterator($folderPath);
        foreach ($directoryIterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                require $folderPath . "/" . $fileInfo->getFilename();
            }
        }
    }
}
