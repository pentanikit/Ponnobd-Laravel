<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor as VisitorModel;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Symfony\Component\HttpFoundation\Response;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Agent::isRobot()){
            $visitor = VisitorModel::where('ip',request()->ip())->exists();

            if(!$visitor){
                $visitor = new VisitorModel();
                $visitor->user_id = auth()->id() ?? null;
                $visitor->ip = request()->ip();
                $visitor->user_agent = request()->userAgent();
                $visitor->last_viewed_at = now();
                $visitor->save();
            }

        }

        return $next($request);
    }
}
