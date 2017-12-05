<?php

    namespace App\Http\Middleware;

    use Closure;

    class IsCare
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
            if (!authority_match('care')) {
                return back()->withErrors(['Auth Level' => "Allowed to Users with minimum Customer CARE authentication!!"]);
            }

            return $next($request);
        }
    }
