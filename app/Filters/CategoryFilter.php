<?php 
namespace App\Filters;

use Closure;
use Illuminate\Database\Query\Builder;

class CategoryFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('category')) {
            $query->where('title', 'like', '%' . request('job_title') . '%');
        }

        return $next($query);
    }
}