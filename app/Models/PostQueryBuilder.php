<?php 

// app/Models/PostQueryBuilder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function search($term)
    {
        return $this->where(function ($query) use ($term) {
            $query->where('id', 'like', "%$term%")
                ->orWhere('title', 'like', "%$term%");
        });
    }

    public function filterByJobTitle($jobTitle)
    {
        return $this->where('title', 'like', "%$jobTitle%");
    }

    public function filterByLocation($location)
    {
        return $this->where('location', 'like', "%$location%");
    }

    public function filterByCategory($category)
    {
        return $this->where('category_id', $category);
    }
}
