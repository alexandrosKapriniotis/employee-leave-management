<?php

namespace app\core;

class Response
{
    /**
     * @param $code
     * @return void
     */
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    /**
     * @param string $url
     * @return void
     */
    public function redirect(string $url)
    {
        header('Location: '.$url);
    }
}