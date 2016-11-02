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

    public function __call($funName,$params)
    {
        header('HTTP/1.0 404 not fount');
        echo '<h1>404 NOT FOUNT</h1>';
        die;
    }

    public function redirect($message, $url = null){
        echo '<script>alert("'.$message.'")</script>';
        if(empty($url)) {
            echo '<script>history.back()</script>';
        }else {
            echo '<script>location.href="'.$url.'"</script>';
        }
    }
}