'use strict';

import path from 'path';
import autoprefixer from 'autoprefixer';
import gulpif from 'gulp-if';

export default function(gulp, plugins, args, config, taskTarget, browserSync) {
  let dirs = config.directories;
  let dest = path.join(taskTarget, dirs.fonts);

  // Sass compilation
  gulp.task('fonts', () => {
    return gulp.src(path.join(dirs.source, dirs.fonts, '**/*{.woff,.woff2,.ttf,.svg,.eot}'))
      .pipe(plugins.plumber())
      .on('error', function(err) {
        plugins.util.log(err);
      })
      .on('error', plugins.notify.onError(config.defaultNotification))

      .pipe(gulp.dest(dest))
  });
}
