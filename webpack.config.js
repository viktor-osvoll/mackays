const path = require("path");
const config = require("./site_config.js");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const WebpackShellPlugin = require("webpack-shell-plugin");
let webpack = require("webpack");

module.exports = {
	entry: {
		app: "./resources/src/js/main.js",
		admin: "./resources/src/js/admin/admin-scripts.js"
	},
	output: {
		path: path.resolve(__dirname, "resources/dist/"),
		filename: "[name].js"
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: "babel-loader",
					options: {
						presets: ["env"]
					}
				}
			},
			{
				test: /\.(css|sass|scss)$/,
				exclude: /(node_modules)/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: "css-loader",
						options: {
							importLoaders: 1,
							url: false,
							sourceMap: true
						}
					},
					"postcss-loader",
					"sass-loader"
				]
			},
			{
				test: /\.(png|svg|jpg|gif)$/,
				use: ["file-loader"]
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf|svg)$/,
				use: [
					{
						loader: "file-loader",
						options: {
							name: "[name].[ext]",
							outputPath: "fonts/"
						}
					}
				]
			}
		]
	},
	devServer: {
		historyApiFallback: true,
		compress: true,
		port: 9000,
		https: config.url.indexOf("https") > -1 ? true : false,
		publicPath: config.fullPath,
		proxy: {
			"*": {
				target: config.url,
				secure: false
			},
			"/": {
				target: config.url,
				secure: false
			}
		}
	},
	plugins: [
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery"
		}),
		new MiniCssExtractPlugin({
			filename: "[name].css",
			chunkFilename: "[id].css"
		}),
		new UglifyJsPlugin({
			sourceMap: true,
			uglifyOptions: {
				ie8: false,
				ecma: 8,
				mangle: true,
				output: {
					comments: false,
					beautify: false
				},
				warnings: false
			}
		}),
		new BrowserSyncPlugin({
			proxy: config.url,
			files: ["**/*.php"],
			reloadDelay: 0
		}),
		new WebpackShellPlugin({
			onBuildStart: ['echo "Starting"'],
			onBuildEnd: [
				"php inc/build_tools/buildCustomizer.php",
				"php inc/build_tools/buildThemeColours.php"
			]
		})
	]
};
