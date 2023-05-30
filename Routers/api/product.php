<?php

/*
All mapping URLs in the Router/api directory must have the "/api" prefix before the URL.
*/
return [
    '/api/san-pham/{slug}' => 'api@ProductController@detail',
    '/api/san-pham' => 'api@ProductController@all'
];
