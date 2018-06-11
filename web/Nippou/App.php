<?php

class App{
	static $APP_NAME = "日報";

	static $TOKEN_LEN = 16;

	static $PASS_B_SALT = "proken";
	static $PASS_A_SALT = "nekorp";

	private static $DB_HOST = "localhost";	// ホスト名
	private static $DB_NAME = "proken";	// DB名
	private static $DB_USER = "ecc"; // ユーザ名
	private static $DB_PASS = "123qwEcc"; // パスワード

	public static function DB(){
		return new PDO("mysql:host=".App::$DB_HOST.";dbname=".App::$DB_NAME,
									App::$DB_USER,
									App::$DB_PASS);
	}
}
