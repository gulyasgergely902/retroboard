const { resolve } = require("path");

module.exports = {
    devServer: {
      proxy: 'http://127.0.0.1:8000'
    },

    pages: {
      index: "resources/frontend/app/src/main.ts"
    },

    chainWebpack: (config) => {
      config.resolve.alias
        .set("@", resolve(__dirname, "resources/frontend/app/src"))
    },
   
     // output built static files to Laravel's public dir.
     // note the "build" script in package.json needs to be modified as well.
     outputDir: './public/assets/app',
   
     publicPath: process.env.NODE_ENV === 'production'
       ? '/assets/app/'
       : '/',
   
     // modify the location of the generated HTML file.
     indexPath: process.env.NODE_ENV === 'production'
       ? './resources/views/app.blade.php'
       : 'index.html'
   }