<?php

namespace Gee;

class Qiniu {

	/**
	 *  静态成品变量 保存全局实例
	 *  @access private
	 */
	static private $_instance = NULL;

	private $bucket;
	private $domain;

	private function __construct() {
		$this->bucket = 'geee';
		$this->domain = 'geee.u.qiniudn.com';
	}

	static public function getInstance() {
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function upload($file, $key = null) {
		$key = $key?$key:uniqid();
		$putPolicy = new \Qiniu_RS_PutPolicy($this->bucket);
		$upToken = $putPolicy->Token(null);
		$putExtra = new \Qiniu_PutExtra();
		$putExtra->Crc32 = 1;
		list($ret, $err) = \Qiniu_PutFile($upToken, $key, $file, $putExtra);
		if ($err !== null) {
		    return $err;
		} else {
		    return $ret;
		}
	}

	public function delete($key) {
		$client = new \Qiniu_MacHttpClient(null);
		$err = \Qiniu_RS_Delete($client, $this->bucket, $key);
		if ($err !== null) {
		    return $err;
		} else {
		    return array('success' => 'success');
		}
	}

	public function url($key) {
		return \Qiniu_RS_MakeBaseUrl($this->domain, $key);
	}
}
