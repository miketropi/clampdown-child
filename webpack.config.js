const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  entry: {
    frontend: './src/main.js',
  },
  output: {
    path: path.join(__dirname, 'dist'),
    filename: '[name].clampdown.bundle.js',
  },
  module: {
    rules: [
      {
        test: /.(css|scss)$/,
        use: [
          // Creates `style` nodes from JS strings
          MiniCssExtractPlugin.loader,
          // Translates CSS into CommonJS
          "css-loader",
          // Compiles Sass to CSS
          "sass-loader",
        ],
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "[name].clampdown.bundle.css",
      chunkFilename: "[id].clampdown.bundle.css"
    })
  ]
}