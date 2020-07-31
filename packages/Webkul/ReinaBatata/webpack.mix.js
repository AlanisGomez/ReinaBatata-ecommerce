const { mix } = require("laravel-mix");
require("laravel-mix-merge-manifest");

var publicPath = "../../../public/themes/reinabatata/assets";

if (mix.inProduction()) {
    publicPath = 'publishable/assets';
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix
    .js(
        __dirname + "/src/Resources/assets/js/app.js",
        "js/reinabatata.js"
    )

    .sass(
        __dirname + '/src/Resources/assets/sass/admin.scss',
        __dirname + '/' + publicPath + '/css/reinabatata-admin.css'
    )
    .sass(
        __dirname + '/src/Resources/assets/sass/app.scss',
        __dirname + '/' + publicPath + '/css/reinabatata.css', {
        includePaths: ['node_modules/bootstrap-sass/assets/stylesheets/',
        ],
    }
    )

    .options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}