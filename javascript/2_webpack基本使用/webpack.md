[TOC]
# webpack基本使用

## .gitignore配置可以忽略所有的node_modules

```javascript

**/node_modules/

node_modules/

```

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




6. 配置输出文件的hash值

- 在src添加print.js
   ```javascript
      export default function printMe() {
        console.log('print me')
      }
    ```
- 在webpack.config.js
```javascript

module.exports = {
  entry: {
    app: './src/index.js',
    print: './src/print.js'
  },
  output: {
    filename: '[name].bundle.js'
  }
}


```

7. 配置HtmlWebpackPlugin

> 有hash值name(见step6)的话,  如果对应的app或者print的名字改变的话那么
> index.html 原本引入的app.bundle.js和 print.bundle.js就需要重新改变
> 如果配置了HtmlWebpackPlugin的话 当app和这print改变的话 index.html
中app.bundle.js和print.bundle.js 不需要手动去改变

它会自动生成index.html 并替换掉原始的index.html

> npm install --save-dev html-webpack-plugin

```javascript
module.exports = {
  entry: {
    app: './src/index.js',
    print1: './src/print.js'
  },
  output: {
    // 此处的name会替换成app和print=> app.bundle.js和 print.bundle.js
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader"
      }
    ]
  },
  plugins: [
    new HtmlWebpackPlugin({
      title: 'HtmlWebpackPlugin'
    })
  ]
}
```

8. 配置CleanWebpackPlugin

> npm install clean-webpack-plugin


clean-webpack-plugin作用是在build之前先清楚dist目录

```javascript
// 在Plugins 里面"添加new CleanWebpackPlugin(['dist'])

const CleanWebpackPlugin = require('clean-webpack-plugin')

module.exports = {
  plugins: [
    // build前会清理dist目录
    new CleanWebpackPlugin(['dist'])

  ]
}
```

9. 配置source maps 

> build之后报错的时候 栈追溯会定位到bundle.js中去 开启了source maps之后就会
定位到原文件中去


```javascript


// 直接添加一个devtool : 'inline-source-map'

module.exports = {
  entry: {
    app: './src/index.js',
    print: './src/print.js'
  },
  devtool: 'inline-source-map',
}
```


10. webpack自带的监听模式

在package.json的scripts中添加watch : webpack --watch

{
    "scripts" : {
        "watch" : "webpack --watch"
    }
}


执行 npm run watch

11. webpack-dev-server 配置实时刷新预览浏览器 

原因: 自带的监听模式只有文件改变时候重新编译 并没有实时刷新浏览器


> npm install --save-dev webpack-dev-server

```javascript
//  在webpack.config.js中添加devServer
module.exports = {
  devtool: 'inline-source-map',
  devServer: {
    // dist文件改变的话就自动刷新浏览器
    contentBase: './dist'
  }
}


// 在package.json中的script添加 start这一栏就可以实现热加载

{
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1",
    "build": "webpack",
    "watch": "webpack --watch",
    "start": "webpack-dev-server --open"
  }
}

```
12. 配置webpack-dev-middleware


> npm install --save-dev express webpack-dev-middleware

- 在output中添加 publicPath : '/'
    ```javascript
      output : {
        filename: '[name].bundle.js'
        publicPath: '/'
      }
    ```
- 在根目录添加server.js
    ```javascript
      const express = require('express')
      const webpack = require('webpack')
      const webpackDevMiddleware = require('webpack-dev-middleware')
      
      
      const app = express()
      const config = require('./webpack.config')
      const compiler = webpack(config)
      
      
      // 告诉express去使用webpack-dev-middleware和 webpack.config.js 
      app.use(webpackDevMiddleware(compiler, {
        pulicPath: config.output.publicPath
      }))
      
      
      app.listen(3000, function () {
        console.log('app listening on port 3000!\n')
      })

    ```
- 在package.json添加 server这一行
    ```javascript
      {
        "name": "src",
        "version": "1.0.0",
        "description": "webpack 使用",
        "main": "index.js",
        "scripts": {
          "test": "echo \"Error: no test specified\" && exit 1",
          "build": "webpack",
          "watch": "webpack --watch",
          "start": "webpack-dev-server --open",
          "server": "node server.js"
        }
      }

    ```
    
- 执行=>  npm run server

> 上面的server没有热加载功能


12. dev-server 热加载

1. 在webpack.config.js添加webpak 和 hot 和 plugins那两行
    ```javascript
    
     const webpack = require('webpack')
     
     module.exports = {
       devServer: {
         // dist文件改变的话就自动刷新浏览器
         contentBase: './dist',
         hot: true
       },
       plugins: [
         new webpack.NamedModulesPlugin(),
         // dev-server需要的热加载
         new webpack.HotModuleReplacementPlugin()
     
       ]
     }
    ```
    
2. 根目录添加dev-server.js
```javascript

const webpackDevServer = require('webpack-dev-server')
const webpack = require('webpack')



const config = require('./webpack.config.js')
const options = {
  contentBase: './dist',
  hot: true,
  host: 'localhost'
}

webpackDevServer.addDevServerEntrypoints(config, options)
const compiler = webpack(config)


const server = new webpackDevServer(compiler, options)


server.listen(5000, 'localhost', ()=> {
  console.log('dev server listening on port 5000')
})

```

3. 在package.json 的scripts中添加
    ```javascript
      "dev": "node dev-server.js"

    ```
4. 执行npm run dev