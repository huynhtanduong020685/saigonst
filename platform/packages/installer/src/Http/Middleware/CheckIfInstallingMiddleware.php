<?php

namespace Botble\Installer\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckIfInstallingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     * @throws FileNotFoundException
     */
    public function handle($request, Closure $next)
    {
        try {
            $content = get_file_data(storage_path('installing'));

            $startingDate = Carbon::parse($content);

            if (!$content || now()->diffInMinutes($startingDate) > 30) {
                abort(404);
            }
        } catch (FileNotFoundException $exception) {
            abort(404);
        }

        return $next($request);
    }
}
