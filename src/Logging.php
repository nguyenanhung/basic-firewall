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
    protected $logPath = '';

    /**
     * Function setLogPath
     *
     * @param $logPath
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/21/2021 34:09
     */
    public function setLogPath($logPath)
    {
        $this->logPath = $logPath;

        return $this;
    }

    /**
     * Function write
     *
     * @param string $message
     * @param array $context
     *
     * @throws Exception
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/24/2021 24:20
     */
    public function write($message = '', $context = array())
    {
        $log = new Logger('firewall');
        $log->pushHandler(new StreamHandler($this->logPath . '/basic-firewall.log', Logger::WARNING));
        $log->error($message, $context);
    }
}
