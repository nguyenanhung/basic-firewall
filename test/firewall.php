<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/01/2021
 * Time: 00:50
 */
require_once __DIR__ . '/../vendor/autoload.php';

use nguyenanhung\PhpBasicFirewall\FirewallIP;

// ==================================== Setup List IP Whitelist
// Setup constants HUNGNG_IP_WHITELIST
defined('HUNGNG_IP_WHITELIST') or define('HUNGNG_IP_WHITELIST', array(
    '127.0.0.1',
    '192.168.0.*',
));
// Or Whitelist Array
$whiteList = array(
    '127.0.0.1',
    '192.168.0.*',
);

// ==================================== Setup List IP Blacklist
// Setup constants HUNGNG_IP_BLACKLIST
defined('HUNGNG_IP_BLACKLIST') or define('HUNGNG_IP_BLACKLIST', array(
    '127.0.0.1',
    '192.168.0.*',
));
// Or Blacklist Array
$blackList = array(
    '192.168.0.50',
);

// ==================================== Start Firewall
$firewall = new FirewallIP();
$firewall->setLogDestination(__DIR__ . '/../cache/FirewallLog.log')
         ->setIpWhiteList($whiteList)
         ->setIpBlackList($blackList)
         ->checkUserConnect(false);

if (true !== $firewall->isAccess()) {
    $firewall->accessDeniedResponse();
}
