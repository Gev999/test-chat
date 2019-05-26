<?php

return array(
    'home'=>'home/index',
    'product/([0-9]+)'=>'product/view/$1',
    'catalog/([0-9]+)'=>'catalog/category/$1',
    'catalog'=>'catalog/index',
    'user/register'=>'user/register',
    '' => 'home/index'
);