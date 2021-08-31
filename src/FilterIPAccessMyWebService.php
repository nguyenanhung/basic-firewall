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
    protected $logDestination;
    // Cấu hình những IP nào được phép gọi vào hệ thống
    protected $ipWhiteList = [
        '127.0.0.1'
    ];

    /**
     * Function getLogDestination
     *
     * @return mixed
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 50:26
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
            0 => 'HTTP_X_FORWARDED_FOR',
            1 => 'HTTP_X_FORWARDED',
            2 => 'HTTP_X_IPADDRESS',
            3 => 'HTTP_X_CLUSTER_CLIENT_IP',
            4 => 'HTTP_FORWARDED_FOR',
            5 => 'HTTP_FORWARDED',
            6 => 'HTTP_CLIENT_IP',
            7 => 'HTTP_IP',
            8 => 'REMOTE_ADDR'
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
        return date('Y-m-d H:i:s') . ' -> IP: ' . $this->getIPAddress() . ' -> is not Whitelist IP access to Service';
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

