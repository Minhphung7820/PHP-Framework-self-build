<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/-chi-tiet-{slug}' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
