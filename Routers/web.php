<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/{cate}' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
