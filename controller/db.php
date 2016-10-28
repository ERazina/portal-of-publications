<?php
	final class Controller_DB {
		public static $connect;
		
		public static function connect() {
			if (!self::$connect) {
				self::$connect = mysqli_connect(HOST, USER, PASS, DB);
				mysqli_set_charset(self::$connect, 'utf8');
			}
		}
		
		private function __construct() {}
		private function __clone(){}
		private function __sleep(){}
		private function __wakeup(){}
		

		public static function escape($val) {
			return mysqli_real_escape_string(self::$connect, $val);
		}
        
        public static function getHash() {
		$str  = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$hash = '';
		
		for ($i = 0; $i < 32; $i++) {
			$hash.= $str[rand(0, 35)];
		}
		
		return $hash;
		}

		public static function createSession($id){
			$session = self::getHash();
			$token   = self::getHash();
            
            setcookie('s', $session, 0, '/portal/');
			setcookie('t', $token, 0, '/portal/');
            
            mysqli_query(self::$connect, "
				INSERT INTO `connect` SET
					`session` = '$session',
					`token`   = '$token',
					`user_id` = $id;
			");
		}
		
		public static function insertUser($values) {
			self::connect();

			$login = self::escape($values['login']);
			$pass = self::escape($values['pass']);
			$pass = md5($pass);
			$name = self::escape($values['name']);

			$query = mysqli_query(self::$connect, "SELECT `id` from `users` WHERE `login` = '$login';");

			if(mysqli_num_rows($query) > 0 ){
				echo "Такой логин уже занят!";
			}
			else{
				$query = "INSERT INTO `users` SET
				`login` = '$login',
				`pass` 	= '$pass',
				`name`  = '$name';
				";
				echo $query;
				mysqli_query(self::$connect, $query);
	            
	            if (mysqli_errno(self::$connect) == 0){
	                $id = mysqli_insert_id(self::$connect);
	                self::createSession($id);
                	if (mysqli_affected_rows(self::$connect) > 0){
                	return $id;
                	}	                
	            }
	            else{
	            	echo mysqli_error(self::$connect);
	            	echo "Проблема с базой";
	            }
			}
		}

		public static function checkUser($userInfo){
			self::connect();
	
			$login = mysqli_real_escape_string(self::$connect, $userInfo['login']);
			$pass  = md5($userInfo['pass']);
			
			$query = "SELECT `id` FROM `users` WHERE `login` = '$login' AND `pass`  = '$pass';";
			$mysqli = mysqli_query(self::$connect, $query);

			if (mysqli_num_rows($mysqli) > 0) {
				$result = mysqli_fetch_assoc($mysqli);
				$id    = (int) $result['id'];
				self::createSession($id);
				return $id;
			}
			else {
				echo "Неверная связка Логин/Пароль!<br>";
				}
		}

		public static function getUserId(){
			self::connect();
			$session = $_COOKIE['s'];
			$token = $_COOKIE['t'];
			$query = "SELECT `user_id` FROM `connect` WHERE `session` = '$session' AND `token` = '$token'";

			$mysqli = mysqli_query(self::$connect, $query);
			if (mysqli_num_rows($mysqli) > 0) {
				$result = mysqli_fetch_assoc($mysqli);
				$id    = (int) $result['user_id'];
				return $id;
			}
			else{
	            echo mysqli_error(self::$connect);
	            }
		}

	    public static function deleteSession($user_id){
	    	self::connect();

	    	$query = "DELETE FROM `connect` WHERE `user_id` = '$user_id';";
	    	$mysqli = mysqli_query(self::$connect, $query);

	    	if (mysqli_errno(self::$connect) == 0) {
				setcookie('s', '', 0, '/portal/');
				setcookie('t', '', 0, '/portal/');
				return true;
			}
			else{
				echo mysqli_error(self::$connect);
			}
	    }

	    public static function insertPublication($table, $values) {
			self::connect();
			$cols = '';
			$vals = '';
			foreach ($values as $column => $value) {
				$cols.= "`" . self::escape($column) . "`,";
				$vals.= "'" . self::escape($value) . "',";
			}
			$cols  = trim($cols, ',');
			$vals  = trim($vals, ',');
			$query = "INSERT INTO `" . self::escape($table) . "` ($cols) VALUE($vals);";
			mysqli_query(self::$connect, $query);
			return mysqli_insert_id(self::$connect);
		}

		public static function getListItem(){
			self::connect();
			$query = "
			SELECT `id`, `heading`, `date`, `type` FROM `news` UNION
			SELECT `id`, `heading`, `date`, `type` FROM `ads` UNION
			SELECT `id`, `heading`, `date`, `type` FROM `articles`
			ORDER BY `date` DESC
			LIMIT 1, 10;
			";

			$res = mysqli_query(self::$connect, $query);
			if (mysqli_errno(self::$connect) == 0) {
				$array = array();
				while($item = mysqli_fetch_assoc($res)) {
					$array[] = $item;
				}
				return $array;
				// echo "<pre>";
				// print_r($array);
				// echo "</pre>";
			}
			else{
				echo mysqli_error(self::$connect);
			}
		}
	}