<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/01/2021
 * Time: 00:50
 */
require_once __DIR__ . '/vendor/autoload.php';

use nguyenanhung\PhpBasicFirewall\FilterIPAccessMyWebService;

$filter = new FilterIPAccessMyWebService();
$filter->setLogDestination(__DIR__ . '/cache')
       ->setIpWhiteList([]);
$check = $filter->checkUserConnect();
if ($check !== true) {
    $filter->writeErrorLog($filter->errorLogMessage());
    echo $filter->accessDenied();
    unset($check);
    unset($filter);
    die;
}
