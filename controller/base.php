<?php
	abstract class Controller_base {
		public static function view($page, $arr = array()) {
			foreach($arr as $var => $val) {
				$$var = $val;
			}
			include "./view/$page.html";
		}
		
		abstract static function start($method);
	}
?>