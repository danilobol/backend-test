<?php

namespace App\Helpers\Filters;

use Illuminate\Support\Str;

trait Filterable
{
    public function scopeFiltered($query, array $allowed)
    {
        foreach ($allowed as $key => $property) {
            if (is_numeric($key)) {
                $this->filter($query, $property);
            } else {
                $this->filter($query, $property, $key);
            }
        }

        return $query;
    }

    private function filter($query, $property, $parameter = null)
    {
        $search = $parameter ?: $property;
        if(!$value = request($search)) {
            return $query;
        }

        $searchMethod = $this->getMethod($search);

        $filterClass = $this->filterClass($query);
        if ($filterClass && method_exists($filterClass, $searchMethod)) {
            return $filterClass->{$searchMethod}($value);
        }

        return $query->where($search, $value);
    }

    private function filterClass($query)
    {
        $className = class_basename($this);
        $filterName = "App\\Filters\\{$className}Filter";

        if (!class_exists($filterName)) {
            return null;
        }

        return new $filterName($query);
    }

    private function getMethod($search)
    {
        $search = str_replace(['.', '-'], '_', $search);

        return Str::camel($search);
    }
}
