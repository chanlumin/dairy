# mysql数据库显示乱码

解决方法就是在my.ini中mysqld的下面添加下面一行characeter_set_server<br>
[mysqld]<br>
port = 3306
`character_set_server=utf81`
  
  重新启动mysql服务器
  - show variables like "character_set%"
  - 临时设置 可以这样 set character_set_server = utf8
# PDD实例 prepare错误 一般是sql语句写的不对