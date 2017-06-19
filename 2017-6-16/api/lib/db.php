<?php
/**
 * 链接数据库并返回数据库链接句柄
 * Created by PhpStorm.
 * User: clm
 * Date: 2017/6/17
 * Time: 0:00
 */

try {
    // 默认不是长连接
    $pdo = new PDO('mysql:host=localhost;dbname=rest','root','');
    // 设置这个属性 数据库是什么类型的 查询出来的就是什么类型的
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
} catch (PDOException $e) {
    die("Error : " . $e->getMessage() . "<br/>");
}
