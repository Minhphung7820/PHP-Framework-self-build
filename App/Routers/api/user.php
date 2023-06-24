<?php

$this->group('api/user', function () {
    $this->add('/send-mail', [\App\Http\Controllers\Api\UserController::class, 'sendMail']);
});
