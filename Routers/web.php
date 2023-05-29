<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/{slug}' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
