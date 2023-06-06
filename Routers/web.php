<?php
$this->add('/', [\Http\Controllers\Frontend\HomeController::class, 'index']);
$this->group('san-pham', function () {
    $this->add('/', [\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(null, function () {
        $this->add('/{cate}/{slug}.html', [\Http\Controllers\Frontend\ProductController::class, 'detail']);
    });
}, ["checkLogin:1:14", "checkRole:44"]);
$this->add("/lien-he", function () {
    echo "Đây là view";
});
