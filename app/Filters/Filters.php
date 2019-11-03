<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class Filters
{
    protected $request, $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        $this->getFilters()
            ->filter(function ($filter) {
                return method_exists($this, $filter);
            })->each(function ($filter, $value) {
                $this->$filter($value);
            });

        return $this->builder;
    }

    public function getFilters(): Collection
    {
        return collect($this->request->only($this->filters))->flip();
    }

}
