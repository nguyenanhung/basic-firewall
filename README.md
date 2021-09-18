[![Latest Stable Version](http://poser.pugx.org/nguyenanhung/basic-firewall/v)](https://packagist.org/packages/nguyenanhung/basic-firewall) [![Total Downloads](http://poser.pugx.org/nguyenanhung/basic-firewall/downloads)](https://packagist.org/packages/nguyenanhung/basic-firewall) [![Latest Unstable Version](http://poser.pugx.org/nguyenanhung/basic-firewall/v/unstable)](https://packagist.org/packages/nguyenanhung/basic-firewall) [![License](http://poser.pugx.org/nguyenanhung/basic-firewall/license)](https://packagist.org/packages/nguyenanhung/basic-firewall) [![PHP Version Require](http://poser.pugx.org/nguyenanhung/basic-firewall/require/php)](https://packagist.org/packages/nguyenanhung/basic-firewall)

# PHP Basic Firewall

Thư viện `PHP Basic Firewall` được xây dựng bằng PHP cung cấp 1 phương thức đơn giản để hạn chế quyền truy cập website / api / webservice dựa vào địa chỉ `IP` truy cập của người dùng

## Hướng dẫn sử dụng

### Cài đặt gói

Cài đặt gói Basic Firewall thông qua composer với lệnh như sau

```shell
composer require nguyenanhung/basic-firewall
```

### Hướng dẫn tích hợp Firewall

Tham khảo cách tích hợp thông qua hướng dẫn tại đoạn code ví dụ dưới đây

```php
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

use nguyenanhung\PhpBasicFirewall\FirewallIP;

// ==================================== Setup List IP Whitelist
// Setup constants HUNGNG_IP_WHITELIST
defined('HUNGNG_IP_WHITELIST') or define('HUNGNG_IP_WHITELIST', array(
    '127.0.0.1',
    '192.168.0.*',
));
// Or Whitelist Array
$whiteList = array(
    '127.0.0.1',
    '192.168.0.*',
);

// ==================================== Setup List IP Blacklist
// Setup constants HUNGNG_IP_BLACKLIST
defined('HUNGNG_IP_BLACKLIST') or define('HUNGNG_IP_BLACKLIST', array(
    '127.0.0.1',
    '192.168.0.*',
));
// Or Blacklist Array
$blackList = array(
    '192.168.0.50',
);

// ==================================== Start Firewall

$firewall = new FirewallIP();
$firewall->setLogDestination(__DIR__ . '/logs/FirewallLog.log')
         ->setIpWhiteList($whiteList)
         ->setIpBlackList($blackList)
         ->checkUserConnect(false);

if (true !== $firewall->isAccess()) {
    $firewall->accessDeniedResponse(); // Response 403 http code, Access Denied message
}

// ==================================== End Firewall

// Pass qua firewall sẽ là các đoạn code thực hiện nghiệp vụ của bạn
```

Trong ví dụ trên, chỉ những IP bắt đầu bằng *192.168.0* (loại trừ *192.168.0.50*) và *127.0.0.1* sẽ được cho phép truy cập bởi Firewall. Tất cả các IP khác  `handle()` sẽ return `false`

* `checkUserConnect(false)` khai báo `true` hoặc `false` để xác định mặc định firewall cho phép hay từ chối truy cập (Optional - Default `false`). `true` nếu mặc định cho phép truy cập, `false` nếu mặc định từ chối
* `setIpWhiteList($whiteList)` khai báo `$whiteList` IP list cho phép truy cập
* `setIpBlackList($blackList)` khai báo `$blackList` IP list từ chối truy cập

### IP List Formats

Firewall hỗ trợ input các IP whitelist và blacklist như sau

Type | Syntax | Details
--- | --- | ---
IPV6|`::1`|Hỗ trợ các viết tắt
IPV4|`192.168.0.1`|
Range|`192.168.0.0-192.168.1.60`|Bao gồm tất cả các IP từ *192.168.0.0* đến *192.168.0.255*<br />và từ *192.168.1.0* đến *198.168.1.60*
Wild card|`192.168.0.*`|Tất cả IP bắt đầu bằng *192.168.0*<br />Nó tương tự với cách khai báo `192.168.0.0-192.168.0.255`
Subnet mask|`192.168.0.0/255.255.255.0`|Tất cả IP bắt đầu bằng *192.168.0*<br />Nó tương tự với cách khai báo `192.168.0.0-192.168.0.255` <br />và `192.168.0.*`
CIDR Mask|`192.168.0.0/24`|Tất cả IP bắt đầu bằng *192.168.0*<br />Nó tương tự với cách khai báo `192.168.0.0-192.168.0.255` <br /> và `192.168.0.*` cũng như `192.168.0.0/255.255.255.0`

## LICENSE

Gói được phân phối bởi giấy phép ![License](http://poser.pugx.org/nguyenanhung/basic-firewall/license), tham khảo chi tiết giấy phép [tại đây](https://github.com/nguyenanhung/basic-firewall/blob/main/LICENSE)

Gói có sử dụng packages `m6web/firewall` được cung cấp bởi `M6Web`, bạn cũng có thể sử dụng riêng packages này theo đường link [tại đây](https://packagist.org/packages/m6web/firewall)

## Hỗ trợ

Nếu có bất kì câu hỏi hoặc cần hỗ trợ nào, liên hệ theo thông tin sau

| Name        | Email                | Skype            | Facebook      |
| ----------- | -------------------- | ---------------- | ------------- |
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung |

From Vietnam with Love ❤️