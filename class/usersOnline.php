<?php


class usersOnline extends ObjectModelCore {

	var $timeout = 600;
	var $count = 0;
	var $error;
	var $i = 0;
	
	function usersOnline () {
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
		$this->count_users();
	}
	
	function ipCheck() {
	/*
	This function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This function tryes to get real IP address.
	Note that getenv() function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	function new_user() {
		
		$insert = Db::getInstance()->Execute("INSERT INTO ". _DB_PREFIX_ ."useronline(timestamp, ip) VALUES ('".$this->timestamp."', '".$this->ip."')");
		if (!$insert) {
			//print_r(mysql_error());
			$this->error[$this->i] = "Unable to record new visitor\r\n";			
			$this->i ++;
		}	
		
	}
	
	function delete_user() {
		$delete = Db::getInstance()->Execute("DELETE FROM ". _DB_PREFIX_ ."useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
		if (!$delete) {
			$this->error[$this->i] = "Unable to delete visitors";
			$this->i ++;
		}
	}
	
	function count_users() {
	
		if (count($this->error) == 0) {
			$data =Db::getInstance()->ExecuteS("SELECT DISTINCT ip FROM ". _DB_PREFIX_ ."useronline");
			
			$count = count($data);
			return $count;
			
		}
	}

}

?>