<?php

namespace Providers;

class SessionHandlerServiceProvider implements BaseServiceProvider
{
    public function boot()
    {
        if (isset($_COOKIE['SESSION_ID_AUTH'])) {
            foreach (json_decode($_COOKIE['SESSION_ID_AUTH'], true) as $guard => $sessionId) {
                session_id($sessionId);
            }
            session_start();
        } else {
            session_start();
        }
    }
}
