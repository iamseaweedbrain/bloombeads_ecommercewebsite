<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use Symfony\Component\HttpFoundation\Response;

    class CheckUserSession
    {
        /**
         * Handle incoming request.
         *
         * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
         */
        public function handle(Request $request, Closure $next): Response
        {
            if (!Session::has('admin_users')) { 
                return redirect()->route('admin.login.form');
            }

            return $next($request);
        }
    }