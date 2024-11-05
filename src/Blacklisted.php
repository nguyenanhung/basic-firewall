<?php

namespace nguyenanhung\PhpBasicFirewall;

class Blacklisted
{
    public function check()
    {
        $IP = getIpAddress();
        $arr = file(__DIR__ . '/config/latest_blacklist.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($arr && !empty($IP)) {
            foreach ($arr as $k => $v) {
                $deny = "deny from " . $IP;
                if (trim($v) == $deny) {
                    header('HTTP/1.1 503 Service Temporarily Unavailable');
                    header('Status: 503 Service Temporarily Unavailable');
                    echo "<h2>503 Request temporarily denied: your IP address (" . $IP . ") in Blacklist</h2>";
                    die;
                }
                unset($deny);
            }
        }
        unset($arr);
        return true;
    }
}
