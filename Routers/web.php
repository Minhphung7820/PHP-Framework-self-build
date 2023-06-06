<?php

$this->group('/san-pham', function () {
    $this->add('/', [\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(null, function () {
        $this->add('/{cate}/{slug}.html', [\Http\Controllers\Frontend\ProductController::class, 'detail']);
    }, ['checkRole:7']);
}, ['checkLogin:1:7'],);
$this->add("/lien-he", function () {
    echo "Đây là view";
}, ['checkLogin:1:13', 'checkRole:43']);
