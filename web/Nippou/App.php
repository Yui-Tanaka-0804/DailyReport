<?php

class App{
	const APP_NAME = "日報";

	const TOKEN_LEN = 16;

	const PASS_B_SALT = "proken";
	const PASS_A_SALT = "nekorp";

	private const DB_HOST = "localhost";	// ホスト名
	private const DB_NAME = "proken";	// DB名
	private const DB_USER = "ecc"; // ユーザ名
	private const DB_PASS = "123qwEcc"; // パスワード

	function DB(){
		return new PDO("mysql:host=".App::DB_HOST.";dbname=".App::DB_NAME,
									App::DB_USER,
									App::DB_PASS);
	}
}
