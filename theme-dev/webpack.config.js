const path = require('path');
const glob = require('glob');
const MiniCssExtractPlugin = require('mini-css-extract-plugin'); 
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const PAGE_SCRIPTS_PATH = './source/js/pages/';


const getEntryPoints = () => {
    const entries = {
        'css-entry': './source/css/tailwind.css',
    };
    const pageFiles = glob.sync(PAGE_SCRIPTS_PATH + '*.ts');
    
    pageFiles.forEach(item => {
        const name = path.basename(item, '.ts');
        entries[name] = path.resolve(__dirname, item);
    });
    
    return entries;
};

module.exports = (_, argv) => {
  const isProduction = argv.mode === 'production';
  
  return {
    mode: isProduction ? 'production' : 'development',
    entry: getEntryPoints(), 
    output: {
        filename: 'js/[name].js', 
        path: path.resolve(__dirname, 'dist'),
        clean: true,
    },
    module: {
      rules: [
        {
          test: /\.css$/,
          use: [
            MiniCssExtractPlugin.loader, 
            'css-loader', 
            'postcss-loader', 
          ],
        },

        {
          test: /\.ts$/,
          use: 'ts-loader',
          exclude: /node_modules/,
        },
      ],
    },
    
    resolve: {
        extensions: ['.ts', '.js'],
    },

    plugins: [
      new MiniCssExtractPlugin({
        filename:  'css/app.min.css', 
      }),
      new BundleAnalyzerPlugin(),
    ],
    optimization: {
        sideEffects: false,
        usedExports: true,
        minimize: isProduction,
        splitChunks: {
            chunks: 'all',
            minSize: 2000,
            cacheGroups: {
                vendor: {
                    name: 'vendors',
                    test: /[\\/]node_modules[\\/]/,
                    priority: -10,
                    reuseExistingChunk: true,
                },
            },
        },
    },
  };
};