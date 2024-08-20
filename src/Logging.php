<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/21/2021
 * Time: 23:27
 */

namespace nguyenanhung\PhpBasicFirewall;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class Logging - Thực hiện việc ghi và lưu trữ log, phân tích log
 *
 * Sử dụng gói Monolog để thực thi các tác vụ ghi log liên quan
 *
 * @package   nguyenanhung\PhpBasicFirewall
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Logging
{
    protected $logDestination = '';

    /**
     * Function setLogDestination
     *
     * @param $logDestination
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/24/2021 57:40
     */
    public function setLogDestination($logDestination): Logging
    {
        $this->logDestination = $logDestination;

        return $this;
    }

    /**
     * Function write
     *
     * @param string $message
     * @param array $context
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/24/2021 23:18
     */
    public function write(string $message = '', array $context = array())
    {
        if (file_exists($this->logDestination)) {
            try {
                $log = new Logger('firewall');
                $log->pushHandler(new StreamHandler($this->logDestination, Logger::WARNING));
                $log->warning($message, $context);
            } catch (Exception $exception) {
                if (!empty($this->logDestination)) {
                    @error_log($exception->getMessage() . PHP_EOL, 3, $this->logDestination);
                } else {
                    @error_log($exception->getMessage() . PHP_EOL, 3);
                }
            }
        }
    }
}
