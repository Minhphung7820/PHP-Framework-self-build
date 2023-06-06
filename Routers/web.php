<?php

$this->group(['checkLogin:1:7'], 'san-pham', function () {
    $this->add('/', [\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(['checkRole:7'], 'a', function () {
        $this->add('/{cate}/{slug}.html', [\Http\Controllers\Frontend\ProductController::class, 'detail']);
    });
});
