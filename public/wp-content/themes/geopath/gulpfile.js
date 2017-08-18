'use strict';

var autoprefixer = require('gulp-autoprefixer');
var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
 
gulp.task('scss', function () {
  return gulp.src('./scss/scss/styles.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
        browsers: ['> 0.1%']
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./css/'));
});

gulp.task('default', function () {
  gulp.watch('./scss/scss/*.scss', ['scss']);
});

//Build css for admin theme
gulp.task('build:admin:css', function(){
    return gulp.src('./scss/admin/admin_style.scss')
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['> 0.1%'],
            cascade: false
        }))
        .pipe(gulp.dest('./css/'));
});

//Build production css file
gulp.task('build:css', function () {
    return gulp.src('./scss/scss/styles.scss')
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['> 0.1%'],
            cascade: false
        }))
        .pipe(gulp.dest('./css/'));
});

gulp.task('build', ['build:css', 'build:admin:css']);