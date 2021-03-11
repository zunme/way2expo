<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

/**
 * Class DeviceDetect
 *
 * A middleware to prevent Internet Explorer from being used.
 *
 * README: In our app we only have one real HTML generating route -- it loads the VueJS front-end -- so this is only applied to that one route. I'd worry about applying this on every page load.
 *
 * @package App\Http\Middleware
 */
class NoIE
{

    protected $browser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        $this->browser = $agent->browser();

        if( false !== strpos( $this->browser, 'IE' ) ) {
            return redirect( '/browser-fail' );
        }

        return $next($request);
    }

}
