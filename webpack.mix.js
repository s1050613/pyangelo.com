let mix = require('laravel-mix');
require('laravel-mix-eslint');

   mix.setPublicPath('public');
   mix.webpackConfig({
     externals: {
        'ace': 'ace',
        'Sk': 'Sk'
     }
   });

   mix.copy('./node_modules/font-awesome/fonts', 'public/fonts/font-awsome');

   mix
     .sass('resources/assets/sass/app.scss', './public/css/pyangelo.css')
     .js('resources/assets/js/app.js', './public/js/app.js')
     .js('./resources/assets/js/quiz.js', './public/js/')
     .js('./resources/assets/js/SkulptSketch.js', './public/js/')
     .js('./resources/assets/js/SkulptSketchCanvasOnly.js', './public/js/')
     .js('./resources/assets/js/playground.js', './public/js/')
     .copy('./resources/assets/js/notify.min.js', './public/js/')
     .copy('./resources/assets/js/lessonToggle.js', './public/js/')
     .copy('./resources/assets/js/lessonToggleTutorialPage.js', './public/js/')
     .copy('./resources/assets/js/lessonComments.js', './public/js/')
     .copy('./resources/assets/js/blogComments.js', './public/js/')
     .copy('./resources/assets/js/blogAlert.js', './public/js/')
     .copy('./resources/assets/js/questionComments.js', './public/js/')
     .copy('./resources/assets/js/questionAlert.js', './public/js/')
     .copy('./resources/assets/js/questionFavourite.js', './public/js/')
     .copy('./resources/assets/js/notifications.js', './public/js/')
     .copy('./resources/assets/js/userSearch.js', './public/js/')
     .copy('./resources/assets/js/subscription.js', './public/js/')
     .copy('./resources/assets/js/new-payment-method.js', './public/js/')
     .copy('./node_modules/skulpt/dist/skulpt.min.js', './public/js/')
     .copy('./node_modules/skulpt/dist/skulpt.min.js.map', './public/js/')
     .copy('./node_modules/skulpt/dist/skulpt-stdlib.js', './public/js/')
     .eslint()
     .version();
