<?php 
namespace App\Filters;

use Closure;
use Illuminate\Database\Query\Builder;

class LocationFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('location')) {
            $query->where('title', 'like', '%' . request('location') . '%');
        }

        return $next($query);
    }
}