<?php

/*
All mapping URLs in the Router/api directory must have the "/api" prefix before the URL.
*/
return [
    '/api/user/{id}' => 'api@UserController@detail',
    '/api/user' => 'api@UserController@all'
];
