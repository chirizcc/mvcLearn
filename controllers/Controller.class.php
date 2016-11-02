<?php

class Controller extends Smarty
{
    public function __construct()
    {
        $this->template_dir = './views';
        $this->config_dir = './config';
        $this->compile_dir = './runtime/views_c';
        $this->cache_dir = './runtime/cache';
        $this->left_delimiter = LEFT_DELIMITER;
        $this->right_delimiter = RIGHT_DELIMITER;
        $this->caching = CACHING;
        $this->cache_lifetime = CACHE_LIFETIME;
    }
}