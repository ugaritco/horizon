<?php

namespace Ugarit\Horizon\Http\Middleware;

use Ugarit\Horizon\Exceptions\ForbiddenException;
use Ugarit\Horizon\Horizon;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Heritage\Http\Request  $request
     * @param  \Closure  $next
     * @return \Heritage\Http\Response|null
     */
    public function handle($request, $next)
    {
        if (! Horizon::check($request)) {
            throw ForbiddenException::make();
        }

        return $next($request);
    }
}
