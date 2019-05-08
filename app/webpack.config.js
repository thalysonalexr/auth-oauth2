var Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('js/app', './resources/assets/js/app.js')
  .addEntry('js/effects', './resources/assets/js/effects.js')
  .addEntry('js/store/http', './resources/assets/js/store/http.js')
  .addEntry('css/style', './resources/assets/js/style.js')
  .addStyleEntry('icons/font-awesome', './resources/assets/icons/font-awesome.scss')
  .addStyleEntry('css/materialize', './resources/assets/css/materialize.scss')
  .addStyleEntry('icons/materialize', './resources/assets/icons/materialize.scss')
  .addEntry('images/app', './resources/assets/images/app.js')
  .autoProvidejQuery()
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .configureFilenames({
    images: '[path][name].[hash:8].[ext]',
  })
;

module.exports = Encore.getWebpackConfig();
