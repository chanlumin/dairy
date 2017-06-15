[TOC]
# 正则表达式

## PHP 常用的正则表达式

- $pattern = 匹配正则表达式
- $subject = 匹配目标数据


```
/**
 * @name : show
 * @description : 数据输出调试函数
 * @param $var : input data
 * @return void
 */
function show($var = null) {
    if(empty($var)) {
        echo 'null';
    } elseif (is_array($var) || is_object($var)) {
        // array, object
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    } else {
        //  string,int,float...
        echo $var;
    }
}

```

## PHP中常用的正则表达式函数

- preg_match与preg_match_all()
- preg_match($pattern, $subject, [array &$matches])
- preg_match_all($pattern, $subject, array &$matches)
- return 匹配到结果的次数


- preg_replace与preg_filter 从$subject中匹配到的东西用$replacement来替换
- preg_replace($pattern, $replacement, $subject)
- preg_filter($pattern, $replacement, $subject)
- str_replace是上面的自己

```
/**
preg_filter只会保留发生替换的字符串
preg_replace会将所有的字符串都保留起来
**/
$pattern = '/[0-9]/';
$pattern = array('/[0123]/','/[456]/','/[789]/');

$subject = 'wasdf123123ljlaj45sdf1989';
$subject = array('hello', '1love','zhofan77','fuck');
$replacement = '周凡';
$replacement = array('周','凡','hello');
$m1 = $m2 = array();
$str1 = preg_replace($pattern,$replacement, $subject);
$str2 = preg_filter($pattern,$replacement, $subject);

```

- preg_grep($pattern, array $input) 只做匹配不做替换
- 阉割版preg_filter(...)

```
$arr = preg_grep($pattern, $subject);
```
- preg_split($pattern, $subject)
- exlode(...) 是preg_split的自己

```
$pattern = '/[0-9]/';
$arr = preg_grep($pattern, $subject);
$pattern  = '/[0-9]/';
$subject = '周1凡2,约吗?';
$arr = preg_split($pattern, $subject);
```
- preg_quote($str)
- 正则运算符转义
- .\+*[^]$(){}=!<>|:-

```
$str = '111{23123}[2342]';
$str = preg_quote($str);
```

## PHP正则表达函数总结
- 都是以preg_开头
- 除preg_quote函数外,第一个参数都是正则表达式子
- preg_match-表单验证
- preg_replace-非法词语过滤

---

# 正则表达式子基本语法

## 概述
- 界定符
- 原子
- 量词
- 边界控制
- 模式单元

## 界定符
- 表示一个正则表达式子的开始和结束
- /[0-9]/ 正则表达式的开始和结束的标志 可以认为不是正则表达式子的组成部分
- #[0-9]#
- {[0-9]} 

## 正则表达是工具
- regexpal

## 原子

- 不可见原子
    - Unicode编码表中用键盘输出后肉眼不可见的字符

- 包括
    - 换行符 \n
    - 回车 \r
    - 制表符 \t
    - 空格
    - 其他不可见符号


> 但凡是汉子的匹配尽量把汉子转为Unicode不然可能会出现编码错误


> 如果想匹配正则表达式的符号要转义 \\

- 不可见原子
    > 空格就直接敲空格 \n匹配换行符 \t匹配制表符


## 元字符
 - 原子的筛选方式
    - | 匹配两个或者多个分支选择
    - [] 匹配方括号中的任意一个原子
    - [^] 匹配方括号中的原子之外的任意字符 只在方括号的左边才有效


- 原子的集合
    - . 匹配除换行符之外的任意字符 [^\n]
    - \d 匹配任意一个十进制数字 [0-9]
    -  \D 匹配任意一个非十进制数字  [^0-9]
    -  \s 匹配一个不可见原子，即[\f\n\r\t\v]
    -  \S 匹配一个可见原子，即[^\f\n\r\t\v]
    -  \w 匹配一个数字、字母或者下划线，[0-9a-zA-Z_]
    -  \W 匹配任意一个非数字、字母或下划线 [^0-9a-zA-Z]


## 量词
- {n} 表示其前面的原子恰好出现n次
- {n,} 表示其前面的的原子最少出现n次
- {n,m} 表示其前面的原子最少出现n次，最多出现m次
- \* 匹配0次、1次或者多次其之前的原子 {0,}
- \+ 匹配1次或者多次其之前的原子,即{1，}
- \? 匹配0次或者1次其之前的原子 {0,1}

```
5{3} 5连续出现三次

[a-zA-Z]{2} 连续出现两个字符

\w{4} 连续出现 数字字母或者下划线

\w{4,8} 匹配四次或者八次

\w* 匹配前面的子表达式任意次

\d+ 匹配一次或者无穷大次的数字 

\d？ 匹配数字0次或者一次

```

## 边界控制

- ^ 匹配字符串开始的位置
- $ 匹配字符串结尾的位置
- ( ) 匹配其中的整体为一个原子

```
^hello$
必须以hello 中的h或者o结束不然匹配不到

```

## 模式单元

- (D|d)uang~ 原括号中匹配出来的东西当成原子

## 懒惰匹配与贪婪匹配

---
# 修正模式

## 懒惰模式与贪婪匹配

- 贪婪匹配  匹配结果存在歧义时取其长
- 懒惰匹配  匹配结果存在歧义的取其短

```
// . 除了换行符号的其他字符
// 懒惰模式就是在正则表达式的后面加上U就行了
$pattern = '/imooc.+123/U';
$subject = 'I love imooc_12312312312313123123';
$matches = array();
// 默认的匹配是贪婪模式
preg_match($pattern, $subject, $matches);
```

## 常见的修正模式
- U-懒惰匹配
- i-忽略英文字母大小写
- x 忽略空白
- s 让元字符 ' . ' 匹配包括换行符在内的所有字符
- e 


# 常见的正则表达式

- .+ (非空) 
- \d+.\d{2}$  保留两位数字的匹配
- 1[34578]\d{9} 或者 1(3|4|5|7|8)\d{9}  匹配手机号
- ^\w+(\.\w+)*@\w+(\.\w+)+$ 匹配email地址
- ^(https?://)?(\w+\.)+[a-zA-Z]+$
## 

# 正则表达式工具类
```
class regexTool
{
    // 存放常用的正则表达式
    private $validate = array(
        'require' => '/.+/',
        'email' => '/^\w+(\.\w+)*@\w+(\.\w+)+$/',
        'url' => '/^(https?://)?(\w+\.)+[a-zA-Z]+$/',
        'currency' => '/^\d(\.\d)?$/',
        'number' => '^/\d+$/',
        'zip' => '^/\d{6}$/',
        'interger' =>'^/[-\+]?\d$/',
        'double'=> '/^[A-Za-z]+$/',
        'english' => '/^\d{5,11}$/',
        'mobile' => '/1(3|4|5|7|8)\d{9}/'

    );
    // 如果为假返回真假  如果为真 返回匹配到的结果
    private $returnMatchResult = false;
    private $fixMode = null;
    private  $matches =  array();
    private $isMatch = false;

    /**
     * regexTool constructor.
     * @param bool $returnMatchResult 返回匹配到的结果
     * @param null $fixMode 修正模式 默认贪婪  U懒惰
     */
    public function __construct($returnMatchResult = false , $fixMode = null)
    {
        $this->returnMatchResult = $returnMatchResult;
        $this->fixMode = $fixMode;
    }

    /**
     * 链接fixMode
     * @param $pattern
     * @param $subject
     * @return array|bool
     */
    private function regex($pattern, $subject) {
        if(array_key_exists(strtolower($pattern), $this->validate)) {
            $pattern = $this->validate[strtolower($pattern)].$this->fixMode;

        }
        $this->returnMatchResult ? preg_match_all($pattern, $subject, $this->matches) :
            $this->isMatch = preg_match($pattern, $subject) === 1;
        return $this->getRegexResult();
    }

    public function getRegexResult() {
        if($this->returnMatchResult) {
            return $this->matches;
        } else {
            return $this->isMatch;
        }
    }

    public function toggleReturnType($bool = null) {
        if(empty($bool)) {
            $this->returnMatchResult = !$this->returnMatchResult;
        } else {
            $this->returnMatchResult = is_bool($bool) ? $bool : (bool)$bool;
        }
    }

    public function setFixMode($fixMode) {
        $this->fixMode  = $fixMode;
    }

    /**
     * @验证非空
     * @param $str
     * @return array|bool
     */
    public function noEmpty($str) {
        return $this->regex('require', $str);
    }

    public function isEmali($email) {
        return $this->regex('email', $email);
    }

    public function isMobile($mobile) {
        return $this->regex('mobile', $mobile);
    }

    public function  check($pattern, $subject) {
        return $this->check($pattern, $subject);
    }
}

regCheck.php中调用

require_once 'regexTool.php';

$regex = new regexTool();

if(!$regex->noEmpty($_POST['username'])) exit('用户名是必须填写的');
if(!$regex->isEmali($_POST['email'])) exit('email格式错误');
if(!$regex->isMobile($_POST['cellphone'])) exit('手机号格式错误');
```

# 简单的模板引擎
```
<?php

class template {
    private $templateDir;
    private $compileDir;
    private $leftTag = '{{';
    private  $rightTag = '}}';
    private $currentTemp = '';
    private $outputHtml;
    private $varPool = array();

    /**
     * template constructor.
     * @param $templateDir 模板的地址
     * @param $compileDir 编译后的地址
     * @param null $leftTag 自定义模板左侧标签
     * @param null $rightTag 自定义模板右侧标签
     */
    public function __construct($templateDir, $compileDir, $leftTag=null, $rightTag=null)
    {
            $this->templateDir = $templateDir;
            $this->compileDir= $compileDir;
            if(!empty($leftTag)) {
                $this->leftTag = $leftTag;
            }
            if(!empty($rightTag)) {
                $this->rightTag = $rightTag;
            }
    }

    /**
     * 给变量赋值
     * @param $tag
     * @param $var
     */
    public function render($tag, $var) {
        $this->varPool[$tag]  = $var;
    }

    /**
     * 获取变量数据
     * @param $tag
     * @return mixed
     */
    public function getVar($tag) {
        return $this->varPool[$tag];
    }

    /**
     * 获取模板源文件地址
     * @param $templateName
     * @param string $ext
     */
    public function  getSourceTemplate($templateName, $ext = '.html') {
        $this->currentTemp = $templateName;
        $sourceFilename = $this->templateDir . $this->currentTemp . $ext;
        $this->outputHtml= file_get_contents($sourceFilename);
    }

    public function compileTemplate($templateName = null, $ext='.html') {
        // 用户输入的为空 使用当前的模板文件 否则使用用户输入的名称
        $templateName = empty($templateName) ? $this->currentTemp : $templateName;
        $pattern = '/' . preg_quote($this->leftTag);
        $pattern .= ' *\$([a-zA-Z_]\w*) *';
        $pattern .= preg_quote($this->rightTag).'/';

//        $1 获取匹配的子模式
        $this->outputHtml = preg_replace($pattern,'<?php echo $this->getVar(\'$1\') ?>', $this->outputHtml);

        $compiledFilename = $this->compileDir.md5($templateName).$ext;
        file_put_contents($compiledFilename, $this->outputHtml);
    }

    public function display($templateNmae = null, $ext = '.html') {
        $templateNmae = empty($templateNmae) ? $this->currentTemp : $templateNmae;
        include_once $this->compileDir.md5($templateNmae).$ext;
    }
}


index.php中调用

require_once 'template.php';

// 将windows下面所有的正斜杠统统替换成返斜杆
$baseDir = str_replace('\\','/',dirname(__FILE__));

$template = new template($baseDir . '/source/', $baseDir . '/compiled/');
$template->render('pageTitle', 'world');
$template->render('test', 'hello');

$template->getSourceTemplate('index');
$template->compileTemplate();
$template->display();
```

---
# javascript 正则表达式

## 认识正则表达式

### RegEXp对象

> Javascript 通过内置对象RegExp支持正则表达式 有两种方法实例化RegExp对象
- 字面量
    - var reg = /\bis\b/g   \b表示单词边界 g表示全文搜索
    
    ```
    var reg =  /\bis\b/;
    'He is a boy This is a dog'.replace(reg, 'IS'); // 全文替换is
    ```
- 构造函数
    - var reg = new RegExp('\\bis\\b','g'); // Javascript中反斜线本身就是特殊字符 如果要使用的话就要进行转义
    
    ```
    var reg = new RexExp('\\bis\\b','g');
    'He is a boy This is zhoufan'.replace(reg, 'IS')
    
    ```
- 修饰符
    - g : global全文搜索，不添加，搜索到第一个匹配停止
    - i : ignore case 忽略大小写，默认大小敏感
    - m : 多行搜索
    
    ```
    'He is a boy. Is he'.replace(/\bis\b/gi,'zhoufan');
    ```

### 原字符
- 正则表达式由两种基本字符组成
    - 原义文本字符   字符本来是什么就代表什么 比如 a b abc
    - 元字符
        -  ^ * + ? $  | {} () []
        - \t \v(垂直制表符) \n \r(回车符) \0(空字符) \f(换页符) \cX(与X对应的控制字符)
    > 元字符是在正则表达式中有特殊含义的非字母字符 


### 字符类
- 我们可以使用元字符[]来构建一个简单的类
- 所谓类是指符合某些特性的对象，一个泛指，而不是特指某个字符
- 表达式[abc]把字符a 或 b 或 c 归为一类, 表达式可以匹配这类的字符

```
'a1b2bc3d4'.replace(/[abc]/g, 'zhoufan');

```

### 字符类取反
- 使用元字符 ^ 创建 反向类/负向类
- 反向类的意思是不属于某类的内容
- [^abc] 表示不是字符a或b或c的内容

```
'a1b2bc3d4'.replace(/[^abc]/g, 'zhoufan');
```

### 范围类
- 正则表达式提供了**范围类**
- 使用[a-z]来连接两个字符表示从a到z的任意字符
- 这是个闭区间，包含a和z本身
- 范围类内部可以连写 [a-zA-Z]

```
'a1b2d3x4k9zhou1ZXHHLHL0fan520'.replace('/[a-zA-Z']/g,'lovezhoufan');
'2019-11-11'.replace(/[0-9-]/g,'hello')
```

### js预定类

- . [^\r\n]  除了回车和换行符之外的字符
- \d [0-9] 数字字符
- \D [^0-9] 非数字字符
- \s [\t\n\x0B\f\r] 非空字符
- \w [a-zA-Z_0-9] 单词字符(字母、数字下划线)
- \W [^a-zA-Z0-9_]  非单词字符


### 边界
- ^ 以XXX开始
- $ 以XXX结束
- \b 单词边界
- \B 非单词边界

```
'This is a boy'.replace(/\Bis\b/g,'zhoufan')
"Thzhoufan is a boy"
'This is a boy'.replace(/\bis\b/g,'zhoufan')
"This zhoufan a boy"


mulStr = '@123\n\
@343\n\
@343\n\
'
"@123
@343
@343
"
mulStr.replace(/^@\d/gm,'zhoufan');
"zhoufan23
zhoufan43
zhoufan43

'@123@abc@'.replace(/@./g,'zhoufan');
"zhoufan23zhoufanbc@"
'@123@abc@'.replace(/^@./g,'zhoufan');
"zhoufan23@abc@"
'@123@abc@'.replace(/.@$/g,'zhoufan');
"@123@abzhoufan"
'@123@abc@'.replace(/.@/g,'zhoufan');
"@12zhoufanabzhoufan"

```

### 量词
> 希望匹配一个连续出现 **20** 次的字符串

-  ？ 出现零次或者一次(最多出现一次)
-  + 出现一次或多次 (至少出现一次);
-  * 出现零次或多次(任意次)
-  {n} 出现n次
-  {n,m} 出现n到m次
-  {n,} 至少出现n次


```
最多10次
\d{0,10}
```

### js正则贪婪模式与非贪婪模式

> 默认正则表达式 在匹配的时候 会努力的进行匹配直到匹配失败

- 非贪婪模式 做法很简单 在量词后加上？即可
    - '123124124'.match(/\d{3,5}?/g)
    > ["123","124","124"]
```
'123213123'.replace(/\d{3,6}/, 'xx')
"xx123"
'123213123'.replace(/\d{3,6}/g, 'xx')
"xxxx"
'123213123'.replace(/\d{3,6}?/g, 'xx')
"xxxxxx"
```

### 分组
> 匹配字符串Byron连续出现**三次**的场景 Bryon{3} 其实他只是匹配n练出出现三次 解决方法就是利用()分组功能 （Byron){3}

```
'a1b2c3d4'.replace(/([a-z]\d){3}/g,'zhoufan');
"zhoufand4"

```
> 或 使用 | 可以达到或的效果 Byron | Casper Byr(on|Ca)sper

```
'ByronsperByrCasper'.replace(/Byr(on|Ca)sper/g,'xx');
"xxxx"
```

### 反向引用

> $1 $2  $3 对分组的内容进行捕获 其中在js中$1$2$3 要用引号包围起来
```

'2017-6-1'.match(/(\d{4})-(\d+)-(\d+)/,'$1$2$3')
(4) ["2017-6-1", "2017", "6", "1", index: 0, input: "2017-6-1"]
'2017-6-1'.match(/(\d{4})-(\d+)-(\d+)/)
(4) ["2017-6-1", "2017", "6", "1", index: 0, input: "2017-6-1"]
'2017-6-1'.replace(/(\d{4})-(\d+)-(\d+)/,'$1/$2/$3')
"2017/6/1"

```

### 前瞻

- 正则表达式从文本头部向文本尾部开始解析，文本尾部方向 称为'前'
- **前瞻**就是正则表达式匹配到规则的时候，向前检查是否符合断言，后顾/后瞻方向相反
- 只参与断言 不参与解析
- JavaScript不支持后顾
- 符合和不符合特定断言称为肯定/正向 匹配 和否定/负向匹配


名称 | 正则 | 含义
---|--- | ---
正向前瞻 | exp(?=assert) | 
负向前瞻 | exp(?!=assert) | 
正向后顾 | exp(?<=assert) | JavaScript不支持
负向后顾 | exp(?<!assert | JavaScript不支持 

```

// 匹配一个单词字符后面是数字
'a2*3'.replace(/\w(?!\d)/g,'x')
"ax*x"
// 匹配一个字符后面不是数字
'a2*3'.replace(/\w(?=\d)/g,'x')
"x2*3"

```

## JS对象属性

- global : 是否全文搜索，默认属性false
- ignore  case : 是否对大小写敏感,默认是false
- multiline:多行搜索，默认是false
- lastIndex:当前表达式匹配表达式最后一个字符的下一个位置
- source ： 正则表达式的文本字符串

```
var reg = /\w/;
var reg1 = /\w/gim;
reg.lastIndex
0
reg.source
"\w"
reg.global
false
reg.ignoreCase
false
reg.multiline
false
reg1.multiline
true
```
## test 和 exec方法
- RegExp.prototype.test(str)
    - 用于测试字符串参数中是否存在正则表达式模式字符串
    - 如果存在返回true,否则返回false
    ```
    var reg2 = /\w/g;
    while(reg2.test('ab')) {
    //每次lastIndex前进一次到最后就跳到0也就没有匹配到
     console.log(reg2.lastIndex);
    }

    ```
- RegExp.prototype.exec(str)
    - 使用正则表达式对字符串执行搜索，并将更新全局RegExp对象的属性以反映匹配结果
    - 如果没有匹配的文本则返回null，否则返回一个数组
       - index 匹配文本的第一个字符串的位置
       - Input 存放被检索的字符串string
       
    ```
    var reg3 = /\d(\w)(\w)\d/
    
    // 当加上/g 的时候执行exec的时候 reg4的lastIndex会记录 否则都是从头开始的
    var reg4 = /\d(\w)(\w)\d/g;
    var ts = '$1la2dd2dd4dddfd4';
    var reg = reg3.exec(ts);
    console.log(reg3.lastIndex + '\t' + reg.index, '\t' + reg.toString());
    console.log(reg3.lastIndex + '\t' + reg.index, '\t' + reg.toString());
    
    while(reg = reg4.exec(ts)) {
        console.log(reg4.lastIndex + '\t' + reg.index + '\t' + reg.toString());
    }
    0	1 	1la2,l,a
    0	1 	1la2,l,a
    5	1	1la2,l,a
    11	7	2dd4,d,d
    ```
- 调用非全局的RegExp对象的exec()时，返回数组
- 第一个元素是与正则表达式相匹配的文本
- 第二个元素是与RegExpObject的第一个子表达式相匹配的文本(如果有的话 子表达式其实就是分组)
- 第三个元素是与RegExp对象的第二个子表达式相匹配的文本(如果有的话).以此类推


## 字符串对象方法
- String.prototype.search(reg)
    - search() 方法用于检索字符串中指定的子字符串或检索与正则表达式相匹配的子字符串
    - 方法返回第一个匹配结果index，查找不到返回-1
    - search() 方法不执行全局匹配，它将忽略标志g，并且总是从字符串的开始进行检索

    ```
    // search 中有g和没有g是一样的
    'a1b1c1'.search(/1/g) ==>  'a1b1c1'.search(/1/);
    
    ```
- String.prototype.match(reg)
    - match()方法将检索字符串，以找到一个或多个与regexp匹配的文本
    - regexp是否具有标志g对结果影响很大
        - 非全局调用
            - 如果regexp没有标志g,那么match()方法就只能在字符串中执行一次匹配
            - 如果没有找到任何撇批文本，讲返回null
            - 否则他将返回一个数组
            - 返回素组的第一个元素存放的是匹配文本，而其余的元素存放的是与正则表达式的子表达式匹配的文本
            - 除了常规的数组元素之外，返回的数组还含有2个对象属性
                - index声明匹配文本的起始字符在字符串的位置
                - input声明对stringObject的引用
        -  全局调用
            - 如果regexp具有标志g 则match()方法 将执行全局检索，找到字符串中的所有匹配子字符串
                - 没有找到任何匹配的字符串，则返回null
                - 如果找到了一个或多个匹配字符串，则返回一个数组
            - 数组元素中存放的是字符串中的所有匹配子串，而且也没有index或input属性

    ```
      var reg3 = /\d(\w)\d/;
    var reg4 = /\d(\w)\d/g;
    
    ts = '1a2b3c3333'
    var ret = ts.match(reg3);
    console.log(ret);
    console.log(ret.index + '\t' + reg3.lastIndex);
    
    ret = ts.match(reg4);
    console.log(ret);
    console.log(ret.index + '\t' + reg4.lastIndex);
    
     (2) ["1a2", "a", index: 0, input: "1a2b3c3333"]
     0	0
     (3) ["1a2", "3c3", "333"]
     undefined	0
    ```
- String.prototype.match(reg)
    - 我们经常使用splite方法吧字符串分割为字符数组
    > 'a.b.c.d'.split('.'); // ['a', 'b','c','d'] 'a.b.c.d'.split(/./);
   
    - 在一些复杂的情况我们可以使用个正则表达式来解决
    > 'a1b2c3d'.split(/\d/); //["a", "b","c","d"]

- String.prototype.replace(str|reg, replaceStr | function)
    - 'a1a13'.replace('/1/g',3);
    -  function参数含义 有四个参数
        1. 匹配字符串
        2. 正则表达式分组内容，没有分组则没有参数
        3. 匹配项在字符串中的index
        4. 原字符串 (如果前面的参数没有，后一个参数往前推移)

    ```
    'a1b2c3d4'.replace(/\d/g,function(match,index,origin) {
    	return parseInt(match) + 1;
    })
    "a2b3c4d5"
    
    'a1b2c3d4e5'.replace(/(\d)(\w)(\d)/g,function(match,group1,group3,group3,index,origin) {
    console.log(match);
	return group1 + group3;
    })
     1b2
     3d4
    "a12c34e5" // 只有b和d被去掉
    ```
