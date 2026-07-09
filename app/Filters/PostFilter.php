<?php 

namespace App\Filters;

use App\Models\PostQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostFilter
{
    public function handle(PostQueryBuilder $builder, Request $request)
    {
        if ($request->has('search')) {
            $builder->search($request->input('search'));
        }

        if ($request->has('job_title')) {
            $builder->filterByJobTitle($request->input('job_title'));
        }

        if ($request->has('location')) {
            $builder->filterByLocation($request->input('location'));
        }

        if ($request->has('category')) {
            $builder->filterByCategory($request->input('category'));
        }
    }

    protected function filterSearch(Builder $builder, $search)
    {
        $builder->where(function ($query) use ($search) {
            $query->where('id', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%");
        });
    }

    protected function filterJobTitle(Builder $builder, $jobTitle)
    {
        $builder->where('title', 'like', "%$jobTitle%");
    }

    protected function filterLocation(Builder $builder, $location)
    {
        $builder->where('location', $location);
    }

    protected function filterCategory(Builder $builder, $category)
    {
        $builder->where('category_id', $category);
    }
}
