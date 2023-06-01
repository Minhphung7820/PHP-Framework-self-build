<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/{cate}/{slug}.html' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
