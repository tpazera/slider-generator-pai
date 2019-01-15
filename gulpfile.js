var gulp = require('gulp');
var livereload = require('gulp-livereload');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var concat = require('gulp-concat');

gulp.task('imagemin', function () {
    return gulp.src('./src/resources/images/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{ removeViewBox: false }],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('./src/resources/images'));
});

gulp.task('sass', function () {
    gulp.src('./src/resources/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 7', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./src/resources/css'));
});

gulp.task('uglify', function () {
    gulp.src([
        './src/resources/lib/*.js'
    ])
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./src/resources/js'));
});

gulp.task('watch', function () {
    livereload.listen();

    gulp.watch('./src/resources/sass/**/*.scss', ['sass']);
    gulp.watch('./src/resources/lib/*.js', ['uglify']);
    gulp.watch(['./src/resources/css/*.css', './src/resources/js/*.js', './src/**/*.php'], function (files) {
        livereload.changed(files);
    });
});
