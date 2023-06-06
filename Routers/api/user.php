<?php
$this->group(['checkLogin'], 'api/pai', function () {
    $this->add('/ssss', [\Http\Controllers\Api\ProductController::class, 'index'], ["cc", "LLL"]);
    $this->group(['middlewa_2'], 'products', function () {
        $this->group(['middlewa_3'], 'cca', function () {
            $this->add('/ukm', [\Http\Controllers\Api\ProductController::class, 'index']);
        });
    });
});
$this->add('ukm', [\Http\Controllers\Api\ProductController::class, 'index']);
