<?php

namespace nguyenanhung\PhpBasicFirewall;

use Exception;
use PDOException;
use PDO;

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
     * Is CLI? - Test to see if a request was made from the command line.
     *
     * @return    bool
     */
    public static function isCLI()
    {
        return (PHP_SAPI === 'cli' or defined('STDIN'));
    }

    /**
     * Function getCurrentPhpVersion
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:29
     */
    public function getCurrentPhpVersion()
    {
        return PHP_VERSION;
    }

    /**
     * Function getPhpMinVersion
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 01:39
     */
    public function getPhpMinVersion()
    {
        return $this->phpMinVersion;
    }

    /**
     * Function setPhpMinVersion
     *
     * @param string $phpMinVersion
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 01:43
     */
    public function setPhpMinVersion($phpMinVersion)
    {
        $this->phpMinVersion = $phpMinVersion;

        return $this;
    }

    /**
     * Function checkPhpVersion
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 01:55
     */
    public function checkPhpVersion()
    {
        $minVersion = $this->phpMinVersion;
        $operator = '>=';

        $message = 'Current PHP Version: ' . PHP_VERSION . ' - Suggest PHP Version ' . $operator . ' ' . $minVersion;

        if (version_compare(PHP_VERSION, $minVersion, $operator)) {
            $code = true;
            $status = 'OK';
        } else {
            $code = false;
            $status = 'NOK';
        }

        return array(
            'code' => $code,
            'message' => $message,
            'status' => $status,
        );
    }

    /**
     * Function phpVersion
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:40
     */
    public function phpVersion()
    {
        $result = $this->checkPhpVersion();
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function connectUsePhpTelnet
     *
     * @param string $hostname
     * @param string $port
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:43
     */
    public function connectUsePhpTelnet($hostname = '', $port = '')
    {
        $message = 'Connection to server ' . $hostname . ':' . $port;
        try {
            $socket = fsockopen($hostname, $port);
            if ($socket) {
                $code = true;
            } else {
                $code = false;
            }
            $result = array(
                'code' => $code,
                'message' => $message,
                'status' => $code === true ? 'OK' : 'NOK'
            );
        } catch (Exception $exception) {
            $result = array(
                'code' => false,
                'message' => $message,
                'status' => 'NOK',
                'errorMessage' => $exception->getMessage()
            );
        }

        return $result;
    }

    /**
     * Function phpTelnet
     *
     * @param string $hostname
     * @param string $port
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:47
     */
    public function phpTelnet($hostname = '', $port = '')
    {
        $result = $this->connectUsePhpTelnet($hostname, $port);
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkExtensionRequirement
     *
     * @param string $extension
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:50
     */
    public function checkExtensionRequirement($extension = '')
    {
        $message = 'Requirement Extension: ' . $extension;
        $code = extension_loaded($extension);

        return array(
            'code' => $code,
            'message' => $message,
            'status' => $code === true ? 'OK' : 'NOK'
        );
    }

    /**
     * Function checkExtension
     *
     * @param string $extension
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:54
     */
    public function checkExtension($extension = '')
    {
        $result = $this->checkExtensionRequirement($extension);
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkFunctionsRequirement
     *
     * @param string $function_name
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:50
     */
    public function checkFunctionsRequirement($function_name = '')
    {
        $message = 'Requirement Extension: ' . $function_name;
        $code = function_exists($function_name);

        return array(
            'code' => $code,
            'message' => $message,
            'status' => $code === true ? 'OK' : 'NOK'
        );
    }

    /**
     * Function checkFunctions
     *
     * @param string $function_name
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:54
     */
    public function checkFunctions($function_name = '')
    {
        $result = $this->checkFunctionsRequirement($function_name);
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkFilePermission
     *
     * @param string $filename
     * @param string $mode
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 02:59
     */
    public function checkFilePermission($filename = '', $mode = 'read')
    {
        $message = 'File ' . $filename;
        if (!file_exists($filename)) {
            $code = false;
            $status = 'NOK';
            $checkStatus = 'File ' . $filename . ' not exists';
        } else {
            $mode = strtolower($mode);
            switch ($mode) {
                case "read":
                    $code = is_readable($filename);
                    $checkStatus = $code === true ? 'Read OK' : 'Read NOK';
                    $status = $code === true ? 'OK' : 'NOK';
                    break;
                case "write":
                    $code = is_writable($filename);
                    $checkStatus = $code === true ? 'Write OK' : 'Write NOK';
                    $status = $code === true ? 'OK' : 'NOK';
                    break;
                case "executable":
                    $code = is_executable($filename);
                    $checkStatus = $code === true ? 'Executable OK' : 'Executable NOK';
                    $status = $code === true ? 'OK' : 'NOK';
                    break;
                default:
                    $code = false;
                    $checkStatus = 'NOK';
                    $status = 'NOK';
            }
        }

        return array(
            'code' => $code,
            'message' => $message,
            'status' => $status,
            'checkStatus' => $checkStatus
        );
    }

    /**
     * Function checkWriteFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 03:02
     */
    public function checkWriteFile($filename = '')
    {
        $result = $this->checkFilePermission($filename, 'write');
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkReadFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 03:06
     */
    public function checkReadFile($filename = '')
    {
        $result = $this->checkFilePermission($filename);
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkExecutableFile
     *
     * @param string $filename
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 03:09
     */
    public function checkExecutableFile($filename = '')
    {
        $result = $this->checkFilePermission($filename, 'executable');
        Output::writeLn($result['message'] . ' -> ' . $result['status']);
    }

    /**
     * Function checkConnectDatabaseWithPDO
     *
     * @param string $host
     * @param string|int $port
     * @param string $database
     * @param string $username
     * @param string $password
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 03:12
     */
    public function checkConnectDatabaseWithPDO($host = '', $port = '', $database = '', $username = '', $password = '')
    {
        $dsnString = "mysql:host=$host;port=$port;dbname=$database";
        try {
            $conn = new PDO($dsnString, $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = array(
                'code' => true,
                'status' => 'OK',
                'message' => "Connected successfully to Database : " . $dsnString . " with username: " . $username . " and your input password",
                'data' => array(
                    'dsnString' => $dsnString,
                    'username' => $username,
                    'status' => 'Connected successfully',
                    'message' => "{{PDO_CONNECT_STATUS}} to Database : {{PDO_DSN_STRING}} with username: {{PDO_USERNAME}} and your input password"
                )
            );
            $conn = null;
        } catch (PDOException $e) {
            $result = array(
                'code' => false,
                'status' => 'NOK',
                'message' => "Connection failed: " . $e->getMessage(),
                'error' => $e->getTraceAsString(),
                'data' => array(
                    'dsnString' => $dsnString,
                    'username' => $username,
                    'status' => 'Connected failed',
                    'message' => "{{PDO_CONNECT_STATUS}} to Database : {{PDO_DSN_STRING}} with username: {{PDO_USERNAME}} and your input password"
                )
            );
        }

        return $result;
    }

    /**
     * Function checkConnectDatabase
     *
     * @param string $host
     * @param string|int $port
     * @param string $database
     * @param string $username
     * @param string $password
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/18/2021 03:16
     */
    public function checkConnectDatabase($host = '', $port = '', $database = '', $username = '', $password = '')
    {
        $result = $this->checkConnectDatabaseWithPDO($host, $port, $database, $username, $password);
        Output::writeLn($result['message']);
        if (isset($result['error'])) {
            Output::writeLn($result['error']);
        }
    }
}
