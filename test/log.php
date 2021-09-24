<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/24/2021
 * Time: 16:59
 */
require_once __DIR__ . '/../vendor/autoload.php';

use nguyenanhung\PhpBasicFirewall\Logging;

$logging = new Logging();
$logging->setLogDestination(__DIR__ . '/../tmp/test-log.log');
$logging->write(
    'Test Message',
    array('hungna', 'hungng')
);

d(directory_map(__DIR__ . '/../tmp'));
