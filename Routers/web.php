<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/{slug}.html' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
