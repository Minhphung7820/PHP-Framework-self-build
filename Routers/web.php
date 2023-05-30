<?php
return [
    '/' => 'frontend@HomeController@index',
    '/san-pham/danh-muc-{cate}/chi-tiet-{slug}.html' => 'frontend@ProductController@detail',
    '/san-pham' => 'frontend@ProductController@all'
];
