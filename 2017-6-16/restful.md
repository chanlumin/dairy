[TOC]

## 如何设计RESTful API
- 资源路径
    > 在RESTful架构中，每个网址代表一种资源，所以网址中不能有动词，只能有名词。一般来说API中的名词应该使用复数
    
    > 例如有一个API提供动物园(zoo)的信息，还包括各种动物和雇员的信息，则他的路径应该设计成下面这样。
    - https://api.example.com/v1/zoos  // 动物园资源
    - https://api.example.com/v1/animals // 动物资源
    - https://api.example.com/v1/employees // 雇员资源
- HTTP动词
    > 对志愿的操作(CURD),由于HTTP动词(谓词)表示
    - GET　：从服务器取出资源(一项或多项).
    - POST : 在服务器新建一个资源
    - PUT ： 在服务器更新资源(客户端提供改变后的完整资源) 服务端返回整个更新资源的信息
    - PATCH : 在服务端更新资源(客户端提供改变属性) 更新完之后服务端只会返回更新的属性 `一般比较少用`
    - DELETE : 从服务器删除资源
    ```php
      POST/zoos: 新建一个动物园 
      GET/zoos/ID: 获取某个指定动物园的信息
      PUT/zoos/ID : 更新某个指定动物园的信息
      DELETE/zoos/ID : 删除某个动物园
     ```
- 过滤信息
    - 如果记录数量很多，服务器不可能将它们都返回给用户API应该提供参数过滤返回结果
    ```php
    ?offset=10 : 指定返回记录的开始位置
    ?offset=2&per_page=100 : 指定第几页，以及每页的记录数
    ?sortby=name&order=asc : 指定返回结果排序, 以及排序顺序。
    ?animal_type_id=1 : 指定筛选条件
    ```
- 状态码
   - 服务器想用户返回的状态码和提示信息，使用标准的HTTP状态码
   - 200 OK 服务器成功返回用户请求的数据，
   - 201 CREATED 新建或修改数据成功
   - 204 NO CONTENT 删除数据成功
   - 400 BAD REQUEST 用户发出的请求有错误，改操作幂等(不管操作多少次返回的结果都是一样)
   - 401  Unauthorized 表示用户没有认证，无法进行当前操作
   - 403 Forbidden 表示用户访问是被禁止的
   - 422 Unprocesahble Entity 当创建一个对象时，发生一个验证错误
   - 500 INTERNAL SERVER ERROR 服务器发生错误，用户将无法判断发出的请求是否成功

- 错误处理
   ```php
      如果状态码是4xx或5xx，就应该向用户返回出错信息。一般来说，返回信息中将error作为键名，出错信息作为键值就可以
    {
        "error" : "参数错误"
    }
    ```
- 返回处理
   > 针对不同的操作，服务器向用户返回的结果应该符合以下规范：
   - GET /collections : 返回资源对象的列表(数组)
   - GET /collections/identity : 返回单个资源对象
   - POST /collections : 返回新生成的对象
   - PUT /collections/identity : 返回完整的资源对象
   - PATCH /collections/identity : 返回被修改的属性
   - DELETE 返回一个空文档

## 确认设计要素
- 项目需求
    - 用户登录、注册
    - 文章发表、编辑、管理、列表
- 确认设计要素
    - 资源路径
        - /users
        - /articles
    -  HTTP
        - GET
        - POST
        - DELETE
        _ PUT
    - 过滤信息
        - 文章的分页筛选
    - 状态码
        - 200
        - 400
        - 422
        - 403
-  错误处理
    - 输出JSON格式错误信息
- 返回结果
    - 输出JSON数组或JSON对象
    
## 数据库设计
- 用户表
> ID 用户名 密码 注册时间
- 文章表
> 文章ID 标题 内容 发表时间 用户ID

