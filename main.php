<?php
	include_once 'config.php';
	
	function __autoload($class) {
		$class = explode('_', $class);
		$path  = '.';
		for ($i = 0, $cnt = count($class); $i < $cnt; $i++) {
			$path.= '/' . $class[$i];
		}
		$path.= '.php';
		
		if (file_exists($path)) {
			include_once $path;
		}
		else {
			die("Запрашиваемой страницы не существует!");
		}
	}
	
	Controller_route::start($_SERVER['REQUEST_URI']);
?>