const mix = require('laravel-mix');
// Admin
mix.webpackConfig({
    output: {
        path:__dirname+'/dist/frontend',
    }

});

mix.sass('sass/app.scss','css');
mix.browserSync({
    proxy:'http://localhost:8000/',
    //host:'booking.test',
    open:"external",
    files: [
        "sass/*.scss",
        "js/**/*.js",
        "../../../themes/Jamrock/**/*.php"
    ]
});
