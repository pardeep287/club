<?php

    namespace App\Http\Middleware;

    use Closure;

    class IsAdmin
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \Closure $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {

            if (!authority_match('admin')) {
                return back()->withErrors(['Auth Level' => "Allowed to admins only!!"]);
            }

            return $next($request);
        }
    }
