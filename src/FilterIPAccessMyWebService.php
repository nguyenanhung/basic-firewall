<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-01-10
 * Time: 16:16
 */

namespace nguyenanhung\PhpBasicFirewall;

/**
 * Class FilterIPAccessMyWebService
 *
 * Hàm hỗ trợ filter IP được phép truy cập vào hệ thống
 */
class FilterIPAccessMyWebService
{
    /** @var string $logDestination */
    protected $logDestination;

    // Cấu hình những IP nào được phép gọi vào hệ thống
    protected $ipWhiteList = array(
        '127.0.0.1'
    );

    /**
     * Function getLogDestination
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 55:50
     */
    public function getLogDestination()
    {
        return $this->logDestination;
    }

    /**
     * Function setLogDestination
     *
     * @param string $logDestination
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 50:21
     */
    public function setLogDestination($logDestination = '')
    {
        $this->logDestination = $logDestination;

        return $this;
    }

    /**
     * Function writeErrorLog
     *
     * @param string $message
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 53:24
     */
    public function writeErrorLog($message = '')
    {
        if (!empty($this->logDestination)) {
            @error_log($message . PHP_EOL, 3, $this->logDestination);
        } else {
            @error_log($message . PHP_EOL, 3);
        }
    }

    /**
     * Function setIpWhiteList
     *
     * @param array $ipWhiteList
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 48:10
     */
    public function setIpWhiteList($ipWhiteList = [])
    {
        $this->ipWhiteList = $ipWhiteList;

        return $this;
    }

    /**
     * Function getIpWhiteList
     *
     * @return string[]
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 48:20
     */
    public function getIpWhiteList()
    {
        return $this->ipWhiteList;
    }

    /**
     * Function checkUserConnect
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-01-10 16:22
     *
     * @return bool
     */
    public function checkUserConnect()
    {
        $ips = $this->getIPAddress();
        if (empty($ips)) {
            return false;
        }

        if (defined('HUNGNG_IP_WHITELIST')) {
            if (in_array($ips, HUNGNG_IP_WHITELIST)) {
                return true;
            }
        }

        if (in_array($ips, $this->ipWhiteList)) {
            return true;
        }

        return false;
    }

    /**
     * Function getIPAddress
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-01-10 16:24
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     */
    public function getIPAddress($convertToInteger = false)
    {
        $ip_keys = array(
            0 => 'HTTP_CF_CONNECTING_IP',
            1 => 'HTTP_X_FORWARDED_FOR',
            2 => 'HTTP_X_FORWARDED',
            3 => 'HTTP_X_IPADDRESS',
            4 => 'HTTP_X_CLUSTER_CLIENT_IP',
            5 => 'HTTP_FORWARDED_FOR',
            6 => 'HTTP_FORWARDED',
            7 => 'HTTP_CLIENT_IP',
            8 => 'HTTP_IP',
            9 => 'REMOTE_ADDR'
        );
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($convertToInteger === true) {
                        return ip2long($ip);
                    }

                    return $ip;
                }
            }
        }

        return false;
    }

    /**
     * Function errorLogMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-01-10 16:29
     *
     * @return string
     */
    public function errorLogMessage()
    {
        $message = date('Y-m-d H:i:s') . ' | Access Denied -> IP: ' . $this->getIPAddress();
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {
            $message .= " - COUNTRY: " . $_SERVER['HTTP_CF_IPCOUNTRY'];
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $message .= " - PROTOCOL: " . $_SERVER['HTTP_X_FORWARDED_PROTO'];
        }
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $message .= " - METHOD: " . $_SERVER['REQUEST_METHOD'];
        }
        if (isset($_SERVER['HTTP_HOST'])) {
            $message .= " - HOST: " . $_SERVER['HTTP_HOST'];
        }
        if (isset($_SERVER['REQUEST_URI'])) {
            $message .= " - URI: " . $_SERVER['REQUEST_URI'];
        }
        if (isset($_SERVER['QUERY_STRING'])) {
            $message .= " - QUERY_STRING: " . $_SERVER['QUERY_STRING'];
        }
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $message .= " - USER_AGENT: " . $_SERVER['HTTP_USER_AGENT'];
        }

        return $message;
    }

    /**
     * Function accessDenied
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-01-10 16:29
     *
     * @return string
     */
    public function accessDenied()
    {
        return 'Access Denied!';
    }
}

