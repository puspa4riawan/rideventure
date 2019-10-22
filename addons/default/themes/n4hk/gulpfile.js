/*jslint node: true */
'use strict';



/*================================================================================================================
    *    Chapther
================================================================================================================*/
//    *  CH01 - Register core modules
//    *  CH02 - Create path source
//    *  CH03 - Define task browserSync
//    *  CH04 - Create function SASS report error
//    *  CH05 - Define task Style
//    *  CH06 - Define task js
//    *  CH07 - Define task images
//    *  CH08 - Define task fonts
//    *  CH09 - Create path minified file PHP & JS
//    *  CH10 - Define task watch
//    *  CH11 - Cleaning generated file automatically
//    *  CH12 - Define task build



/*================================================================================================================
//    *  CH01 - Register core modules
================================================================================================================*/
var gulp = require('gulp'),
    include = require('gulp-include'),
    sass = require('gulp-sass'),
    sasslint = require('gulp-sass-lint'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    sourcemaps = require('gulp-sourcemaps'),
    useref = require('gulp-useref'),
    uglify = require('gulp-uglify'),
    terser = require('gulp-terser'),
    gulpIf = require('gulp-if'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    gutil = require('gulp-util'),
    minimist = require('minimist'),
    imagemin = require('gulp-imagemin'),
    cache = require('gulp-cache'),
    del = require('del'),
    browserSync = require('browser-sync').create();



/*================================================================================================================
//    *  CH02 - Create path source
================================================================================================================*/
var paths = {

    // Create path for style files
    styles: {
        src: 'resource/scss/**/*.scss',
        dest: 'resource/css',
        exceptFiles: '!sass/dont-watch-this.scss'
    },
    // Create path for php files
    php: {
        src: 'resource/*.php'
    },
    // Create path for js files
    js: {
        src: 'resource/js/**/*.js',
        dest: 'public/js'
    },
    // Create path images
    img: {
        src: 'resource/img/**/*.+(png|jpeg|jpg|gif|svg)',
        dest: 'public/img'
    },
    // Create path fonts
    fonts: {
        src: 'resource/fonts/**/*',
        dest: 'public/fonts'
    },
    // Create path browserSync local address
    localAddress: {
        filePath: 'office/n4hk/resource'
    }
};



/*================================================================================================================
//    *  CH03 - Define task browserSync
================================================================================================================*/
// Define task liveReload
function liveReload() {
    browserSync.init({
        proxy: "http://localhost/" + paths.localAddress.filePath + '/index.php',
        middleware: function(req, res, next) {
            res.setHeader('Cache-Control', 'no-cache, max-age=0');
            next();
        }
    });    
};

// Expose task liveReload
exports.liveReload = liveReload;

// Define task reload
function reload(done){
    browserSync.reload()
    done();
};



/*================================================================================================================
//    *  CH04 - Create function SASS report error
================================================================================================================*/
var reportError = function (error) {
    var lineNumber = (error.lineNumber) ? 'LINE ' + error.lineNumber + ' -- ' : '';

    notify({
        title: 'Task Failed [' + error.plugin + ']',
        message: lineNumber + 'See console.',
        sound: 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
    }).write(error);

    gutil.beep(); // Beep 'sosumi' again

    // Inspect the error object
    //console.log(error);

    // Easy error reporting
    //console.log(error.toString());

    // Pretty error reporting
    var report = '';
    var chalk = gutil.colors.white.bgRed;

    report += chalk('TASK:') + ' [' + error.plugin + ']\n';
    report += chalk('PROB:') + ' ' + error.message + '\n';
    if (error.lineNumber) { report += chalk('LINE:') + ' ' + error.lineNumber + '\n'; }
    if (error.fileName)   { report += chalk('FILE:') + ' ' + error.fileName + '\n'; }
    console.error(report);

    // Prevent the 'watch' task from stopping
    this.emit('end');
}



/*================================================================================================================
//    *  CH05 - Define task Style
================================================================================================================*/
// Define task style
function style() {
    return gulp.src(
        paths.styles.src,
        paths.styles.exceptFiles
    )
        .pipe(plumber({
            errorHandler: reportError
        }))
        .pipe(sasslint())
        .pipe(sasslint.format())
        .pipe(sasslint.failOnError())
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: ['node_modules', 'node_modules/node-normalize-scss/', 'node_modules/sass-mediaqueries/']
        }).on('error', sass.logError))
        .pipe(postcss([
            autoprefixer(),
            cssnano()
        ]))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.reload({
            stream: true
        }));
};

// Expose task style
exports.style = style;



/*================================================================================================================
//    *  CH06 - Define task js
================================================================================================================*/
// Define task js
function js() {
    return gulp.src(paths.js.src)
        .pipe(gulp.dest(paths.js.dest));
};

// Expose task js
exports.js = js;



/*================================================================================================================
//    *  CH07 - Define task images
================================================================================================================*/
function images() {
    return gulp.src(paths.img.src)
        .pipe(cache(imagemin({
            interlaced: true
        })))
        .pipe(gulp.dest(paths.img.dest));
};

// Expose task images
exports.images = images;



/*================================================================================================================
//    *  CH08 - Define task fonts
================================================================================================================*/
function fonts() {
    return gulp.src(paths.fonts.src)
        .pipe(gulp.dest(paths.fonts.dest));
};

// Expose task fonts
exports.fonts = fonts;



/*================================================================================================================
//    *  CH09 - Create path minified file PHP & JS
================================================================================================================*/
// Define task useref
function usereff() {
    return gulp.src(paths.php.src)
        .pipe(useref())
        .pipe(gulpIf('*.js', terser()))
        .pipe(gulp.dest('public'))
};

// Expose task useref
exports.usereff = usereff;



/*================================================================================================================
//    *  CH10 - Define task watch
================================================================================================================*/
// Expose task watch
function watchSource() {
    // Watch Style
    gulp.watch(paths.styles.src, style);
    // Watch PHP
    gulp.watch(paths.php.src, gulp.series(reload));
    // Watch JS
    gulp.watch(paths.js.src, gulp.series(reload));
};

// Expose task watch
exports.watchSource = watchSource;

// Create task gulp default
var watch = gulp.parallel(liveReload, watchSource);
gulp.task('default', watch);



/*================================================================================================================
//    *  CH11 - Cleaning generated file automatically
================================================================================================================*/
function clean() {
    return del([ 'public' ]);
}

exports.clean = clean;



/*================================================================================================================
//    *  CH12 - Define task build
================================================================================================================*/
var build = gulp.series(clean, gulp.parallel(style, usereff, js, images, fonts ));
gulp.task('build', build);
