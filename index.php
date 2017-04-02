<?php 

// require __DIR__.'/lib/User.php';
require __DIR__.'/lib/Article.php';
$pdo = require __DIR__.'/lib/db.php';

/* $user = new User($pdo);

($user->login('admin2','admin'));
 */
$art = new Article($pdo);
print_r($art->view(2));



?>