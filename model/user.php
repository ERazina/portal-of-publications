<?php
	class Model_user {

		public static function addNewUser($newUserInfo = array()){
            if (!empty($newUserInfo)) {
				return Controller_DB::insertUser($newUserInfo);
				}
			else {
				return true;
			}
        }

        public static function getNewUser($userInfo = array()){
        	if (!empty($userInfo)) {
				return Controller_DB::checkUser($userInfo);
				}
			else {
				return true;
			}
        }

        public static function getCurrentUser(){
        	if(!empty($_COOKIE)){
        		return Controller_DB::getUserId();
        	}
			else{
				exit("Для корректной работы необходимо включить куки. Или просто авторизоваться");
			}
        }

        public static function logOutUser($id){
        	if (!empty($id)) {
				return Controller_DB::deleteSession($id);
				}
			else {
				exit("Не удалось получить id пользователя для удаления");
			}
        }
    } 
?>