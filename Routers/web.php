<?php
// ========== Home
$this->add('/', [\Http\Controllers\Frontend\HomeController::class, 'index']);
// ===========Products
$this->group('product', function () {
    $this->add('/', [\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(null, function () {
        $this->add('/{cate}/{slug}.html', [\Http\Controllers\Frontend\ProductController::class, 'detail']);
    });
});
// =======Contact
$this->add("/contact", function () {
    echo "Đây là view";
});
// ======= Auth
$this->group('user', function () {
    $this->add('/login', [\Http\Controllers\Frontend\UserController::class, 'login']);
    $this->add('/logout', [\Http\Controllers\Frontend\UserController::class, 'logout']);
    $this->add('/dashboard', [\Http\Controllers\Backend\DashboardController::class, 'index'], ['checkLogin']);
});
