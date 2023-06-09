<?php
// ========== Home
$this->add('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index']);
// ===========Products
$this->group(null, function () {
    $this->add('/san-pham', [\App\Http\Controllers\Frontend\ProductController::class, 'all']);
    $this->group(null, function () {
        $this->add('/{cate}/{slug}.html', [\App\Http\Controllers\Frontend\ProductController::class, 'detail']);
    });
});
// =======Contact
$this->add("/contact", function () {
    echo "Đây là view";
});
// ======= Auth

$this->group(null, function () {
    $this->group('user', function () {
        $this->add('/dashboard', [\App\Http\Controllers\Backend\DashboardController::class, 'index']);
    });
}, ['checkJWT:user']);


$this->group('user', function () {
    $this->add('/login', [\App\Http\Controllers\Frontend\UserController::class, 'login']);
    $this->add('/logout', [\App\Http\Controllers\Frontend\UserController::class, 'logout'], ['checkJWT:user']);
});
