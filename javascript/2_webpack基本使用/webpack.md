[TOC]
# webpack基本使用

1. npm init
2. 安装webpack和webpack-cli

```javascript
npm install webpack webpack-cli  --save-dev
``` 

3. 配置webpack.config.js和 package.json
> 此时可以运行webpack了但是还是不能写es6  

> 运行语句是 npm run webpack

```javascript
const path = require('path')


module.exports = {
  entry: './src/index.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist')
  }
}

// 在pacakge.json的scripts中添加"build": "webpack"
{
   "scripts": {
     "test": "echo \"Error: no test specified\" && exit 1",
     "build": "webpack"
   }
}


```
4. 添加babel模块

- 安装babel-loader babel-core
    ```javascript
      npm install --save-dev babel-loader babel-core
    ```
- 配置webpack.config.js中module中的rules
    ```javascript
    module: {
      rules: [
        {test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader'}
      ]
    }

    ```
    
5. 为了让Babel生效=> 创建.babelrc

```javascript
npm install babel-preset-env --save-dev

```

> 配置.babelrc 这样就可以使用babel
```javascript
{
  "presets": ["env"]
}

```


6. 配置热加载


