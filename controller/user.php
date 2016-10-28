<?php
	class Controller_user extends Controller_base {
		public static function start($method) {
			if (!$method) {
				self::showUserMenu();
			}
			else {
				self::$method();
			}
		}
        
        public static function showUserMenu() {
			self::view('usermenu');
		}
        
        public static function reg() {
            if (empty($_POST)) {
				self::view('reg');
			}
			else {
                if (Model_user::addNewUser($_POST)) {
         			echo "Вы успешно зарегистрировались <br>";
         			header('Location: /' . BASE . 'publication');
				}
				else {
					echo 'Ой, это не вы, это мы: не удалось вас зарегистрировать!';
				}
			}
		}

		public static function auth(){
			if (empty($_POST)) {
				self::view('auth');
			}
			else {
				if (Model_user::getNewUser($_POST)) {
					echo "Вы успешно авторизовались";
					header('Location: /' . BASE . 'publication/');
				}
				else {
					echo 'Ой, это не вы, это мы: не удалось вас опознать!';
				}
			}
		}

		public static function logout(){
			if(Model_user::getCurrentUser()){
				$user_id = Model_user::getCurrentUser();
				if(Model_user::logOutUser($user_id)){
					echo "Вы успешно разлогинились";
				}
				else{
					exit("Проблема с удалением сессии");
				}
			}
			else{
				echo "Ой, это не вы, это мы: не удалось разлогинить вас.<br/>";
			}
		}
    }
?>