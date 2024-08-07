<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait ApiTrait
{
    public function scopeIncluded(Builder $query){
        if(empty($this->allowedIncludes) || !request()->has('included')) return $query;

        $relations = explode(',',request('included'));

        $allowedIncludes = collect($this->allowedIncludes);

        foreach ($relations as $key => $relationship) {
            if(!$allowedIncludes->contains($relationship)){
                unset($relations[$key]);
            }
        }

        return ($query->with($relations));
    }

    public function scopeFilter(Builder $query){
        if(empty($this->allowedFilters) || !request()->has('filter')) return $query;

        $filters = request('filter');
        $allowedFilters = collect($this->allowedFilters);

        foreach ($filters as $filter => $value) {
            if($allowedFilters->contains($filter)){
                $query->where($filter, 'LIKE' , '%' . $value . '%');
            }
        }

        return $query;
    }

    public function scopeSort(Builder $query){
        if(empty($this->allowedSorts) || !request()->has('sort')) return $query;

        $sortFields = explode(',', request('sort'));

        $allowedSorts = collect($this->allowedSorts);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if(Str::startsWith($sortField, '-')){
                $direction = 'desc';
                $sortField = Str::substr($sortField, 1);
            }

            if($allowedSorts->contains($sortField)){
                $query->orderBy($sortField, $direction);
            }
        }

        return $query;
    }

    public function scopeGetOrPaginate(Builder $query){
        if(request()->has('perPage')){
            $perPage = (int) request('perPage');
            if($perPage){
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }
}