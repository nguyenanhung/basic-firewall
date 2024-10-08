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
     * Function register_error_handler
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     *
     * @return bool
     * @throws ErrorException
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/24/2021 26:08
     */
    function register_error_handler($errno, $errstr, $errfile, $errline)
    {
        if (($errno & error_reporting()) > 0) {
            throw new ErrorException($errstr, 500, $errno, $errfile, $errline);
        }

        return false;
    }
}
if (!function_exists('php_basic_firewall')) {
    /**
     * Function php_basic_firewall
     *
     * @param bool $defaultState
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 00:10
     */
    function php_basic_firewall(bool $defaultState = false)
    {
        $firewall = new nguyenanhung\PhpBasicFirewall\FirewallIP();
        $firewall->checkUserConnect($defaultState);
        if (true !== $firewall->isAccess()) {
            $firewall->accessDeniedResponse();
        }
    }
}
if (!function_exists('php_basic_firewall_save_log')) {
    /**
     * Function php_basic_firewall_save_log
     *
     * @param string $logFile
     * @param bool $defaultState
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 17:22
     */
    function php_basic_firewall_save_log(string $logFile = '', bool $defaultState = false)
    {
        $firewall = new nguyenanhung\PhpBasicFirewall\FirewallIP();
        $firewall->setLogDestination($logFile)->checkUserConnect($defaultState);
        if (true !== $firewall->isAccess()) {
            $firewall->writeErrorLog($firewall->errorLogMessage());
            $firewall->accessDeniedResponse();
        }
    }
}
