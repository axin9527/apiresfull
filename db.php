<?php
/* 数据库是PDO连接 */
$dsn = 'mysql:host=localhost;dbname=edu';
$username = 'root';
$passwd = 'root';

try {
$pdo = new PDO($dsn, $username, $passwd);

    if ($pdo){
    return $pdo;
    }
} catch (Exception $e) {
   echo $e->getMessage('数据库连接失败！');
}



