<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelServiceProvider extends ServiceProvider
{
    /**
     * Ensure the compiled views directory exists on Vercel's read-only filesystem.
     *
     * Vercel only allows writing to /tmp. When VIEW_COMPILED_PATH is set to
     * /tmp/views, this provider creates that directory before Blade attempts
     * to write compiled templates.
     */
    public function boot(): void
    {
        $compiledViewPath = config('view.compiled');

        if ($compiledViewPath && ! is_dir($compiledViewPath)) {
            mkdir($compiledViewPath, 0755, true);
        }
    }
}
