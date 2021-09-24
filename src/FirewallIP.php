<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-01-10
 * Time: 16:16
 */

namespace nguyenanhung\PhpBasicFirewall;

use M6Web\Component\Firewall\Firewall;

/**
 * Class FirewallIP - Hàm hỗ trợ filter IP được phép truy cập vào hệ thống
 *
 * @package   nguyenanhung\PhpBasicFirewall
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class FirewallIP
{
    /** @var string $logDestination */
    protected $logDestination;

    /**
     * @var array Cấu hình các IP được phép truy cập vào hệ thống
     */
    protected $ipWhiteList = array('127.0.0.1');

    /**
     * @var array Cấu hình các IP không được phép truy cập vào hệ thống
     */
    protected $ipBlacklist = array();

    /** @var bool Access Roles */
    protected $access = false;

    /** @var bool Bypass if Use CLI */
    protected $cliBypass = false;

    /**
     * Function setCliBypass
     *
     * @param false $cliBypass
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 09:28
     */
    public function setCliBypass(bool $cliBypass = false): FirewallIP
    {
        $this->cliBypass = $cliBypass;

        return $this;
    }

    /**
     * Function isCliBypass
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 13:47
     */
    public function isCliBypass(): bool
    {
        return $this->cliBypass;
    }

    /**
     * Function isCLI
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 14:09
     */
    public function isCLI(): bool
    {
        return CheckSystem::isCLI();
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
    public function setLogDestination(string $logDestination = ''): FirewallIP
    {
        $this->logDestination = $logDestination;

        return $this;
    }

    /**
     * Function setIpWhiteList
     *
     * @param array $ipWhiteList
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 29:42
     */
    public function setIpWhiteList(array $ipWhiteList = array()): FirewallIP
    {
        $this->ipWhiteList = $ipWhiteList;

        return $this;
    }

    /**
     * Function setIpBlackList
     *
     * @param array $ipBlacklist
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 29:46
     */
    public function setIpBlackList(array $ipBlacklist = array()): FirewallIP
    {
        $this->ipBlacklist = $ipBlacklist;

        return $this;
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
    public function getIPAddress(bool $convertToInteger = false)
    {
        $IPKeys = array(
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
        foreach ($IPKeys as $key) {
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
    public function errorLogMessage(): string
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
    public function accessDenied(): string
    {
        return 'Access Denied!';
    }

    /**
     * Function accessDeniedResponse
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 41:56
     */
    public function accessDeniedResponse()
    {
        http_response_code(403);
        exit($this->accessDenied());
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
    public function writeErrorLog(string $message = '')
    {
        if (!empty($this->logDestination)) {
            @error_log($message . PHP_EOL, 3, $this->logDestination);
        } else {
            @error_log($message . PHP_EOL, 3);
        }
    }

    /**
     * Function checkUserConnect
     *
     * @param bool $defaultState
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 59:34
     */
    public function checkUserConnect(bool $defaultState = false): FirewallIP
    {
        $firewall = new Firewall();
        $firewall->setDefaultState($defaultState);
        if (defined('HUNGNG_IP_WHITELIST') && is_array(HUNGNG_IP_WHITELIST)) {
            $firewall->addList(HUNGNG_IP_WHITELIST, 'local', true);
        } elseif (!empty($this->ipWhiteList)) {
            $firewall->addList($this->ipWhiteList, 'local', true);
        }
        if (defined('HUNGNG_IP_BLACKLIST') && is_array(HUNGNG_IP_BLACKLIST)) {
            $firewall->addList(HUNGNG_IP_BLACKLIST, 'localBad', false);
        } elseif (!empty($this->ipBlacklist)) {
            $firewall->addList($this->ipBlacklist, 'localBad', false);
        }
        $this->access = $firewall->setIpAddress($this->getIPAddress())->handle();

        // Nếu chạy từ CLI -> bypass

        return $this;
    }

    /**
     * Function isAccess
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 41:24
     */
    public function isAccess(): bool
    {
        return $this->access;
    }

}

