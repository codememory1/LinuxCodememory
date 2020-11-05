let gulp = require('gulp'),
    sass = require('gulp-sass'),
    uglify = require('gulp-uglify-es').default,
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    del = require('del'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber');

    //

gulp.task('clean', async function(){
  del.sync('src/Build')
})

gulp.task('scss', function(){
  return gulp.src('src/Assets/sass/**/*.scss')
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(autoprefixer({
      browsers: ['last 8 versions']
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('src/Build/css'))
});

gulp.task('css', function(){
  return gulp.src([
    'node_modules/normalize.css/normalize.css',
    'node_modules/slick-carousel/slick/slick.css',
  ])
    .pipe(gulp.dest('src/Assets/sass/'))
});

gulp.task('html', function(){
  return gulp.src('app/*.html')
});

gulp.task('script', function(){
  return gulp.src('src/Assets/js/*.js')
});

gulp.task('js', function(){
  return gulp.src(['src/Assets/js/*.js'])
  .pipe(plumber())
	.pipe(concat('app.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('src/Build/js'))
});

gulp.task('jsSeparately', function() {
  return gulp.src(['src/Assets/js/compress/*.js'])
  .pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(uglify())
	.pipe(gulp.dest('src/Build/js'))
});


gulp.task('export', function(){
  let buildHtml = gulp.src('app/**/*.html')
    .pipe(gulp.dest('dist'));

  let BuildCss = gulp.src('src/Assets/**/*.css')
    .pipe(gulp.dest('src/Build/css'));

  let BuildJs = gulp.src('src/Assets/js/**/*.js')
    .pipe(gulp.dest('src/Build/js'));
    
  let BuildFonts = gulp.src('src/fonts/**/*.*')
    .pipe(gulp.dest('src/Build/fonts'));

  let BuildImg = gulp.src('app/img/**/*.*')
    .pipe(gulp.dest('src/Build/img'));   
});

gulp.task('watch', function(){
  gulp.watch('src/Assets/sass/**/*.scss', gulp.parallel('scss'));
  gulp.watch('src/Assets/js/*.js', gulp.parallel('js'));
  gulp.watch('src/Assets/js/*.js', gulp.parallel('jsSeparately'));
});

gulp.task('build', gulp.series('clean', 'export'))

gulp.task('default', gulp.parallel('watch'));