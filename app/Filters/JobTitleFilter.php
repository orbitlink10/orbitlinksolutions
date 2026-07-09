<?php 
namespace App\Filters;

use Closure;
use Illuminate\Database\Query\Builder;

class JobTitleFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('job_title')) {
            $query->where('title', 'like', '%' . request('job_title') . '%');
        }

        return $next($query);
    }
}