<?php
header("Content-type: text/html;charset=utf-8");

require  __DIR__ . '/lib/user.php';
require __DIR__ . '/lib/article.php';
$pdo = require __DIR__ . '/lib/db.php';
//$user = new User($pdo);
//print_r($user->login('lumin','lumin'));

$article = new Article($pdo);
//print_r($article->create("周凡爱我","我爱周凡",3));
//print_r($article->view(18));
//print_r($article->edit(7,'周凡爱我','我爱周凡',3));
//var_dump($article->delete(8,3));
//var_dump($article->getList(3,1,2));
//print_r($_SERVER);