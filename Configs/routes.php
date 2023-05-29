<?php
return [
    '/' => 'HomeController@index',
    '/san-pham/{slug}' => 'ProductController@detail',
    '/san-pham' => 'ProductController@all'
];
