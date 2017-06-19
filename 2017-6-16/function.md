[TOC]
# PHP 函数
## PHP函数的可变参数实现方式一
- func_num_args()
- func_get_args()
- func_get_args()
> 主要在5.5以及更早的时候实现
```php
function get_num() {
    $args_sum = func_num_args();
    $sum = 0;
    if($args_sum == 0) {
        return $sum;
    } else {
        for($i = 0 ; $i < $args_sum ; $i++) {
            $sum += func_get_arg($i);
        }
    }
    return $sum;
}
echo get_num();
echo get_num(1,2,3);
```
## 实现方式2
> 5.6 以及更晚
```php
function get_sum1(...$nums) {
    $sum = 0;
    if(!$nums) {
        return $sum;
    } else {
        foreach ($nums as $num) {
            $sum += $num;
        }
        return $sum;
    }
}
```

## 值传递引用传递
- 传递方式
    - 值传递 
    - 引用传递
- 传递类型
    - 数值
    - 对象
    - 字符串
    - 数组
   
## 变量的作用域

- 变量范围与生命周期
    - 局部变量
        1. 当前页面中生命的普通变量不能再函数或者类中起作用
        ```php
          $a = 1;
          function test() {echo $a;} // Undefined variable a
        ```
        2. 当前页面中声明的普通变量，不能被传递到其他页面
        3. 在函数中声明的变量，在函数内部有效
        4. 在类中声明的属性，在类的内部有效
    - 全局变量
    > 对于php而言 在页面中定义的变量都是全局变量,在整个页面都有效，但是不能被函数或者类中的方法访问
    
    > 超全局变量可以被类或方法访问，但是不能作为可变参数 如下
    $_GET $_POST $_COOKIE $_SERVER $_FILES $_ENV $_REQUEST $_SESSION
    ```php
        $v1 = 1;
        $v2 = 2;
        function test_global() {
           // global $v1,$v2; // 通过global引用$v1 或者$v2 只是一种值传递接收数据  
           // $v2 = &$v1;  
          $GLOBALS['v2'] = &$GLOBALS['v1']; // 此处v1变量引用不引用都没什么关系
        } 
        
    ```
    - 静态变量
    ```php
   $static $hallo = 1;// 可以
   $static $hallo = sqrt(10);// 不可以 $static 不能用函数表达式进行赋值
    ```
## 复杂函数

### 可变函数

```php
/**
* 可变函数可以通过变量加上()来调用
**/
function get_zhoufan($zhoufan) {
    return $zhoufan . ' love lumin';
}
function get_lumin($lumin) {
    return $lumin . ' love zhoufan';
}
//$func = 'get_zhoufan';
//echo $func() . '\n';
//
//$func = 'get_lumin';
//echo $func();

/**
* @拼接函数变量
**/
function get_love($fun_name,$other_name){
    $opt = 'get_' . $fun_name;
    return $opt($other_name);
}
echo get_love('zhoufan','zhoufan');
echo '<br>';
echo get_love('lumin','lumin');
```

## 嵌套函数
- PHP嵌套函数 当外部函数被调用的时候 内部第一层函数 就会自动进入全局域中，成为新的定义函数
```php
function out($msg_str) {
    // 不存在 就定义 否则的话会调用出错
    if(!function_exists('in')) {
        function in($msg_str) {
            echo 'in' . $msg_str  . '<br>';
            echo '如果外部函数out()没有定义的话 我是不存在的';
         }
    }
    echo 'out' . $msg_str . '<br>';
    in($msg_str);
}
out();
in();
out();
function f_out() {
    echo '<br>out <br>';
    if(!function_exists('f_mid'))
    {
        function f_mid() {
            echo 'mid <br>';
            if(!function_exists('f_in'))
            {
                function f_in()
                {
                        echo 'in <br>';
                }
            }
        }
    }
}
```

## 匿名函数
 - 匿名函数,也叫闭包函数，允许临时创建一个没有指定名称的函数，最经常用作回调函数(callback)参数的值
 
 ```php
  
$hello = "老婆，嫁给我";
$example = function () use(&$hello){
    echo '周凡 ' . $hello . '<br>';
};
$hello = '我爱你啊';
// 闭包外部的变量的时要用 use($variable) 同时他也只能使用在闭包前面定义的变量
// 除非用引用不然 在调用前重新给变量赋值是没有用的
$example();

function Closure($name, Closure $clo) {
    // 此处需要双引号 才能输出$name3 的值
    echo "{$name} I love you";
    $clo();
}
Closure('zhoufan', function () {
    echo '<br> I love you too';
});
 ```
 
 ## 代码复用
- 单独引用 
    - include 与 require
    > 如果要丢失文件停止脚本程序执行的时候 就用require
    如果需要 错误的时候 还可以执行 那么就用include 
    - include_once 与 require_once  
    
- 路径引用
    - set_include_path || ini_set('include_path','str')
    - get_include_path

    ```php
    echo get_include_path(). PATH_SEPARATOR . '<br>';
    //.;C:\php\pear;
    // get_include_path 代表此文件当前的目录
    //set_include_path(get_include_path(). PATH_SEPARATOR . 'testA');
    //set_include_path(get_include_path(). PATH_SEPARATOR . 'testB');
    
    ini_set('include_path', get_include_path() . PATH_SEPARATOR . 'testA');
    ini_set('include_path', get_include_path() . PATH_SEPARATOR . 'testB');
    //ini_set('include_path', 'testA');
    // 替代set_include_path
    //restore_include_path();
    include 'test1.php';
    include "test2.php";
    test1();
    test2();
    ```
    
    
    