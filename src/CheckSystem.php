<?php

namespace nguyenanhung\PhpBasicFirewall;

use Exception;
use PDO;
use PDOException;

/**
 * Class CheckSystem
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class CheckSystem
{
    protected $phpMinVersion = "5.4";

    /**
     * Function getPhpMinVersion
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 47:25
     */
    public function getPhpMinVersion()
    {
        return $this->phpMinVersion;
    }

    /**
     * Function setPhpMinVersion
     *
     * @param $phpMinVersion
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 45:20
     */
    public function setPhpMinVersion($phpMinVersion)
    {
        $this->phpMinVersion = $phpMinVersion;

        return $this;
    }

    /**
     * Function phpVersion
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 45:58
     */
    public function phpVersion()
    {
        $minVersion = $this->phpMinVersion;
        $operator   = '>=';

        $message = 'Phiên bản PHP hiện tại là: ' . PHP_VERSION . ' - phiên bản khuyến nghị ' . $operator . ' ' . $minVersion;

        $status = version_compare(PHP_VERSION, $minVersion, $operator) ? 'HỢP LỆ' : 'KO HỢP LỆ';
        $result = $message . ' => ' . $status;

        Output::writeLn($result);
    }

    /**
     * Function phpTelnet
     *
     * @param string $hostname
     * @param string $port
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:20
     */
    public function phpTelnet($hostname = '', $port = '')
    {
        try {
            $socket  = fsockopen($hostname, $port);
            $message = 'Kết nối đến server ' . $hostname . ':' . $port . '';
            $status  = $socket ? 'THÀNH CÔNG' : 'THẤT BẠI';
            $result  = $message . ' => ' . $status;

            Output::writeLn($result);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Function checkExtension
     *
     * @param string $extension
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:24
     */
    public function checkExtension($extension = '')
    {
        $message = 'Tiện ích yêu cầu -> ' . $extension;
        $status  = extension_loaded($extension) ? 'ĐƯỢC CÀI ĐẶT' : 'CHƯA ĐƯỢC CÀI ĐẶT';
        $result  = $message . ' => ' . $status;

        Output::writeLn($result);
    }

    /**
     * Function checkWriteFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:29
     */
    public function checkWriteFile($filename = '')
    {
        $message = 'File ' . $filename;
        $status  = is_writable($filename) ? 'ĐƯỢC CẤP QUYỀN GHI' : 'KHÔNG ĐƯỢC CẤP QUYỀN GHI';
        $result  = $message . ' => ' . $status;

        Output::writeLn($result);
    }

    /**
     * Function checkReadFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:34
     */
    public function checkReadFile($filename = '')
    {
        $message = 'File ' . $filename;
        $status  = is_readable($filename) ? 'ĐƯỢC CẤP QUYỀN ĐỌC' : 'KHÔNG ĐƯỢC CẤP QUYỀN ĐỌC';
        $result  = $message . ' => ' . $status;

        Output::writeLn($result);
    }

    /**
     * Function checkExecutableFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:42
     */
    public function checkExecutableFile($filename = '')
    {
        $message = 'File ' . $filename . '';
        $status  = is_executable($filename) ? 'ĐƯỢC CẤP QUYỀN THỰC THI' : 'KHÔNG ĐƯỢC CẤP QUYỀN THỰC THI';
        $result  = $message . ' => ' . $status;

        Output::writeLn($result);
    }

    /**
     * Function checkConnectDatabase
     *
     * @param string $host
     * @param string $port
     * @param string $database
     * @param string $username
     * @param string $password
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/01/2021 46:46
     */
    public function checkConnectDatabase($host = '', $port = '', $database = '', $username = '', $password = '')
    {
        try {
            $dsnString = "mysql:host=$host;port=$port;dbname=$database";
            $conn      = new PDO($dsnString, $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            Output::writeLn("Connected successfully to Database : " . $dsnString . " with username: " . $username . " and password: " . $password);
            $conn = null;
        } catch (PDOException $e) {
            Output::writeLn("Connection failed: " . $e->getMessage());
            Output::writeLn($e->getTraceAsString());
        }
    }
}
