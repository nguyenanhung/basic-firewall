<?php
/**
 * Project basic-firewall
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 23:59
 */

namespace nguyenanhung\PhpBasicFirewall;

/**
 * Class Output
 *
 * @package   nguyenanhung\PhpBasicFirewall
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Output
{
    /**
     * Function writeLn
     *
     * @param        $message
     * @param string $newLine
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/02/2021 42:50
     */
    public static function writeLn($message, string $newLine = "\n")
    {
        if (function_exists('json_encode') && (is_array($message) || is_object($message))) {
            $message = json_encode($message);
        }
        echo $message . $newLine;
    }
}
