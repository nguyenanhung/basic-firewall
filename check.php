<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/01/2021
 * Time: 00:55
 */
require_once __DIR__ . '/vendor/autoload.php';

use nguyenanhung\PhpBasicFirewall\CheckSystem;

$system = new CheckSystem();

// Kiểm tra phiên bản PHP
$system->phpVersion();

// Kiểm tra các extension cần thiết
$system->checkExtension('curl');
$system->checkExtension('pdo');
$system->checkExtension('mysqli');
$system->checkExtension('gd');
$system->checkExtension('mbstring');
$system->checkExtension('json');
$system->checkExtension('session');
$system->checkExtension('sockets');
$system->checkExtension('bcmath');

// Kiểm tra kết nối tới 1 server nào đó
$system->phpTelnet('127.0.0.1', 3306);
$system->phpTelnet('127.0.0.1', 2842);

// Kiểm tra kết nối CSDL
$system->checkConnectDatabase('127.0.0.1', 3306, 'test_data', 'root', 'hungna');
