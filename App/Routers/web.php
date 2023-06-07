<?php
// ========== Home
$this->add('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index']);
// ===========Products
$this->group('product', function () {
    $this->add('/', [\App\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(null, function () {
        $this->add('/{cate}/{slug}.html', [\App\Http\Controllers\Frontend\ProductController::class, 'detail']);
    });
});
// =======Contact
$this->add("/contact", function () {
    echo "Đây là view";
});
// ======= Auth
$this->group('user', function () {
    $this->add('/login', [\App\Http\Controllers\Frontend\UserController::class, 'login']);
    $this->add('/logout', [\App\Http\Controllers\Frontend\UserController::class, 'logout']);
    $this->add('/dashboard', [\App\Http\Controllers\Backend\DashboardController::class, 'index'], ['checkLogin']);
});
