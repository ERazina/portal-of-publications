<?php
	class Controller_route {
		public static function start($url) {
			$url    = str_replace(BASE, '', trim($url, '/'));
			$info   = explode('/', $url);
			$class  = 'Controller_' . $info[0];
			$method = isset($info[1]) ? htmlspecialchars($info[1]) : '';
			$id     = isset($info[2]) ? (int)$info[2] : 0; 
			$class::start($method, $id);
		}
	}
?>