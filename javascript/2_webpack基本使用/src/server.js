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
