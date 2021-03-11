const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.browserSync({
    open: false,
    notify: false,
    proxy: 'nginx'
});
/*
mix.options({
    terser: {
        terserOptions: {
            compress: {
                drop_console: true,
            }
        }
    }
})

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);
*/
/* Desktop */
mix.styles([
        'resources/css/desktop.css',
    ], 'public/assets/css/style.css')
    .styles([
        'resources/css/live.css',
    ], 'public/assets/css/live.css')
    .js([
        'resources/js/desktop_bootstrap.js',
    ], 'public/assets/js/desktop_bootstrap.js')
    .js('resources/js/liveCast.js', 'public/assets/js/liveCast.js')
    .js('resources/js/liveView.js', 'public/assets/js/liveView.js')
    .js('resources/js/wordfilter.js', 'public/assets/js/wordfilter.js')
    .combine([
        'resources/js/desktop.js',
    ], 'public/assets/js/web.js')
mix.version();

/* Mobile */
mix.styles([
        'resources/css/mobile.css',
    ], 'public/css/mobile.css')
    .js('resources/js/mobile_bootstrap.js', 'public/js/mobile_bootstrap.js')
	.combine(
			[
				'resources/js/mobile_route.js',
			], 'public/js/mobile_route.js'
		  )
    .combine(
        [
            //'resources/js/mobile_route.js',
            'resources/js/mobile_app.js',
            'resources/js/mobile_default.js',
			'resources/js/wordfilter.js'
        ], 'public/js/mobile_app.js'
      )
    .version();
