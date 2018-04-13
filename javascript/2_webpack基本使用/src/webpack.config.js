const path = require('path')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')
const webpack = require('webpack')

module.exports = {
  entry: {
    app: './src/index.js',
    print: './src/print.js'
  },
  devtool: 'inline-source-map',
  devServer: {
    // dist文件改变的话就自动刷新浏览器
    contentBase: './dist',
    hot: true
  },
  output: {
    // 此处的name会替换成app和print=> app.bundle.js和 print.bundle.js
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'dist'),
    // 保证server 能确保服务端script能够保证所有的文件都被副放在http://localhost:3000
    publicPath : '/'
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
    }),
    // build前会清理dist目录
    new CleanWebpackPlugin(['dist']),
    //看哪些依赖被添加进去
    new webpack.NamedModulesPlugin(),
    // dev-server需要的热加载
    new webpack.HotModuleReplacementPlugin()

  ]
}