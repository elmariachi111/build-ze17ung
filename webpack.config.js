// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
// directory where all compiled assets will be stored
  .setOutputPath('web/build/')

  // what's the public path to this directory (relative to your project's document root dir)
  .setPublicPath('/build')

  // empty the outputPath dir before each build
  .cleanupOutputBeforeBuild()

  // will output as web/build/app.js
  .addEntry('app', './app/assets/js/main.js')

  // will output as web/build/global.css
  .addStyleEntry('global', './app/assets/css/global.scss')

  // allow sass/scss files to be processed
  .enableSassLoader({
    resolve_url_loader: false
  })

  // allow legacy applications to use $/jQuery as a global variable
  //.autoProvidejQuery()
  .autoProvideVariables({
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery',
    Tether: 'tether', tether: 'tether',
    'salvattore': 'salvattore',
    _: 'lodash'
  })

  .enablePostCssLoader()

  .enableSourceMaps(!Encore.isProduction())

  .createSharedEntry('vendor', [
    'jquery',
    'bootstrap',
    'tether',
    'salvattore',
    'lodash',
    'backbone'
  ])

// create hashed filenames (e.g. app.abc123.css)
  .enableVersioning(Encore.isProduction())
;
let config = Encore.getWebpackConfig();
config.watchOptions = { poll: true, ignored: /node_modules/ };

// export the final configuration
module.exports = config;