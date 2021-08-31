<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/01/2021
 * Time: 01:00
 */
if (!function_exists('register_error_handler')) {
    /**
     * @throws \ErrorException
     */
    function register_error_handler($errno, $errstr, $errfile, $errline)
    {
        if (($errno & error_reporting()) > 0) {
            throw new ErrorException($errstr, 500, $errno, $errfile, $errline);
        } else {
            return false;
        }
    }
}
