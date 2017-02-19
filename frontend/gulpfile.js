var gulp = require('gulp');
var minify = require('gulp-minify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');



gulp.task('default', function () {
    // place code for your default task here
});

var watcher = gulp.watch(['js/**/*.js', 'css/**/*.css'], ['compress', 'minify-css']);
watcher.on('change', function (event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
});



gulp.task('compress', function () {

    return gulp.src(
            [
                //'js/**/*.js'

                //Library
                'bower_components/jquery/dist/jquery.js',
                'bower_components/angular/angular.js',
                'bower_components/angular-sanitize/angular-sanitize.min.js',
                'bower_components/angular-ui-mask/dist/mask.js',
                'bower_components/angular-animate/angular-animate.js',
                'bower_components/angular-translate/angular-translate.js',
                'bower_components/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js',
                'bower_components/angular-route/angular-route.js',
                'bower_components/angular-resource/angular-resource.js',
                'bower_components/angular-filter/dist/angular-filter.min.js',
                //Common Files

                'js/helpers/resolver.js',
                'js/helpers/functions.js',
                'js/app.js',
                'js/providers.js',
                'js/animations.js',
                'js/filters.js',
                //Controllers
                'js/controllers/BaseCtrl.js',
                'js/controllers/LoginCtrl.js',
                'js/controllers/ServiceManagementCtrl.js',
                'js/controllers/HeaderUserInfoCtrl.js',
                'js/controllers/LanguagesCtrl.js',
                'js/controllers/CallfriendCtrl.js',
                'js/controllers/CallForwardingCtrl.js',
                //Services

                'js/services/Interceptors.js',
                'js/services/Authentication.js',
                'js/services/ServiceManagement.js',
                'js/services/Error.js',
                'js/services/Success.js',
                'js/services/Storage.js',
                //Directives
                'js/directives/changenumber.js',
                'js/directives/loading.js'
            ])
            .pipe(concat('concat.js'))
            .pipe(gulp.dest('dist'))
            .pipe(rename('script.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('dist'));


});

gulp.task('minify-css', function () {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'css/*.css'
    ]).pipe(concat('style.css')).pipe(gulp.dest('dist')).pipe(rename('style.min.css'))
            .pipe(cleanCSS({compatibility: 'ie8'}))
            .pipe(gulp.dest('dist'));
});