<?php

namespace Providers;

use Providers\BaseServiceProvider;
use DirectoryIterator;

class HelperServiceProvider implements BaseServiceProvider
{
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
