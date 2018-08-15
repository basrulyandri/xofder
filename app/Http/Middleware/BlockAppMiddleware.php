<?php

namespace App\Http\Middleware;

use Closure;

class BlockAppMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $block = \App\Setting::whereSettingKey('kasir_is_blocked')->first();

        if($block->setting_value == '1' && $block->updated_at->isToday()){            
            return redirect()->route('kasir.blocked');            
        }

        return $next($request);            
    }
}
