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
use nguyenanhung\Libraries\Filesystem\Filesystem;

$randomLogFile = __DIR__ . '/../tmp/' . randomNanoId() . '.log';
$file          = new Filesystem();
$file->fileCreate($randomLogFile);

$logging = new Logging();
$logging->setLogDestination($randomLogFile);
$logging->write(
    'Test Message',
    array(
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId(),
        randomNanoId()
    )
);

d(directory_map(__DIR__ . '/../tmp'));
d(file_get_contents($randomLogFile));