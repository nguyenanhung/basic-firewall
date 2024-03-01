<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-01-10
 * Time: 16:16
 */

namespace nguyenanhung\PhpBasicFirewall;

use nguyenanhung\Component\Firewall\Firewall;

/**
 * Class FirewallIP - Hàm hỗ trợ filter IP được phép truy cập vào hệ thống
 *
 * @package   nguyenanhung\PhpBasicFirewall
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class FirewallIP
{
	/** @var string $logDestination Log File */
	protected $logDestination;

	/**
	 * @var array Cấu hình các IP được phép truy cập vào hệ thống
	 */
	protected $ipWhiteList = array('127.0.0.1');

	/**
	 * @var array Cấu hình các IP không được phép truy cập vào hệ thống
	 */
	protected $ipBlacklist = array();

	/** @var bool Access Roles */
	protected $access = false;

	/** @var bool Bypass if Use CLI */
	protected $cliBypass = false;

	/**
	 * Function setCliBypass
	 *
	 * @param false $cliBypass
	 *
	 * @return $this
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 09:28
	 */
	public function setCliBypass(bool $cliBypass = false): FirewallIP
	{
		$this->cliBypass = $cliBypass;

		return $this;
	}

	/**
	 * Function isCliBypass
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 13:47
	 */
	public function isCliBypass(): bool
	{
		return $this->cliBypass;
	}

	/**
	 * Function isCLI
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 14:09
	 */
	public function isCLI(): bool
	{
		return CheckSystem::isCLI();
	}

	/**
	 * Function setLogDestination
	 *
	 * @param string $logDestination
	 *
	 * @return $this
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/01/2021 50:21
	 */
	public function setLogDestination(string $logDestination = ''): FirewallIP
	{
		$this->logDestination = $logDestination;

		return $this;
	}

	/**
	 * Function setIpWhiteList
	 *
	 * @param array $ipWhiteList
	 *
	 * @return $this
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 29:42
	 */
	public function setIpWhiteList(array $ipWhiteList = array()): FirewallIP
	{
		$this->ipWhiteList = $ipWhiteList;

		return $this;
	}

	/**
	 * Function setIpBlackList
	 *
	 * @param array $ipBlacklist
	 *
	 * @return $this
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 29:46
	 */
	public function setIpBlackList(array $ipBlacklist = array()): FirewallIP
	{
		$this->ipBlacklist = $ipBlacklist;

		return $this;
	}

	/**
	 * Function getIPAddress
	 *
	 * @param bool $convertToInteger
	 *
	 * @return bool|int|string
	 * @author: 713uk13m <dev@nguyenanhung.com>
	 * @time  : 2019-01-10 16:24
	 *
	 */
	public function getIPAddress(bool $convertToInteger = false)
	{
		$IPKeys = array(
			0 => 'HTTP_CF_CONNECTING_IP',
			1 => 'HTTP_X_FORWARDED_FOR',
			2 => 'HTTP_X_FORWARDED',
			3 => 'HTTP_X_IPADDRESS',
			4 => 'HTTP_X_CLUSTER_CLIENT_IP',
			5 => 'HTTP_FORWARDED_FOR',
			6 => 'HTTP_FORWARDED',
			7 => 'HTTP_CLIENT_IP',
			8 => 'HTTP_IP',
			9 => 'REMOTE_ADDR'
		);
		foreach ($IPKeys as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				$ips = explode(',', $_SERVER[$key]);
				foreach ($ips as $ip) {
					$ip = trim($ip);
					if ($convertToInteger === true) {
						return ip2long($ip);
					}

					return $ip;
				}
			}
		}

		return false;
	}

	/**
	 * Function errorLogMessage
	 *
	 * @return array
	 * @author: 713uk13m <dev@nguyenanhung.com>
	 * @time  : 2019-01-10 16:29
	 *
	 */
	public function errorLogMessage(): array
	{
		$context = array(
			'IP' => $this->getIPAddress(),
			'COUNTRY' => $_SERVER['HTTP_CF_IPCOUNTRY'] ?? '',
			'PROTOCOL' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '',
			'METHOD' => $_SERVER['REQUEST_METHOD'] ?? '',
			'HOST' => $_SERVER['HTTP_HOST'] ?? '',
			'URI' => $_SERVER['REQUEST_URI'] ?? '',
			'QUERY_STRING' => $_SERVER['QUERY_STRING'] ?? '',
			'USER_AGENT' => $_SERVER['HTTP_USER_AGENT'] ?? '',
		);
		$message = $this->getIPAddress() . ' -> Access Denied!';

		return array(
			'message' => $message,
			'context' => $context
		);
	}

	/**
	 * Function accessDenied
	 *
	 * @return string
	 * @author: 713uk13m <dev@nguyenanhung.com>
	 * @time  : 2019-01-10 16:29
	 *
	 */
	public function accessDenied(): string
	{
		return 'Access Denied!';
	}

	/**
	 * Function accessDeniedResponse
	 *
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 41:56
	 */
	public function accessDeniedResponse()
	{
		http_response_code(403);
		exit($this->accessDenied());
	}

	/**
	 * Function writeErrorLog
	 *
	 * @param array $data
	 *
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/24/2021 13:31
	 */
	public function writeErrorLog(array $data = array())
	{
		$log = new Logging();
		$log->setLogDestination($this->logDestination)->write($data['message'], $data['context']);
	}

	/**
	 * Function checkUserConnect
	 *
	 * @param bool $defaultState
	 *
	 * @return $this
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 59:34
	 */
	public function checkUserConnect(bool $defaultState = false): FirewallIP
	{
		$firewall = new Firewall();
		$firewall->setDefaultState($defaultState);
		if (defined('HUNGNG_IP_WHITELIST') && is_array(HUNGNG_IP_WHITELIST)) {
			$firewall->addList(HUNGNG_IP_WHITELIST, 'local', true);
		} elseif (!empty($this->ipWhiteList)) {
			$firewall->addList($this->ipWhiteList, 'local', true);
		}
		if (defined('HUNGNG_IP_BLACKLIST') && is_array(HUNGNG_IP_BLACKLIST)) {
			$firewall->addList(HUNGNG_IP_BLACKLIST, 'localBad', false);
		} elseif (!empty($this->ipBlacklist)) {
			$firewall->addList($this->ipBlacklist, 'localBad', false);
		}
		$this->access = $firewall->setIpAddress($this->getIPAddress())->handle();

		// Nếu chạy từ CLI -> bypass

		return $this;
	}

	/**
	 * Function isAccess
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/18/2021 41:24
	 */
	public function isAccess(): bool
	{
		return $this->access;
	}

}

