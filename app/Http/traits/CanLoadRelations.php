<?php

namespace App\Http\traits;

use Illuminate\Contracts\Database\Eloquent\Builder as eBuilder;
use Illuminate\Database\Query\Builder as qBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelations
{

    public function loadRelations(Model|eBuilder|qBuilder|HasMany $for, ?array $relations = null): Model|eBuilder|qBuilder|HasMany
    {

        $relations = $relations ?? $this->relations ?? [];

        foreach ($relations as $relation) {
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }


    protected function shouldIncludeRelation(string $relation): bool
    {
        $includes = request()->query('include');

        if (!$includes) {
            return false;
        }

        $relations = array_map('trim', explode(',', $includes));

        return in_array($relation, $relations);
    }
}
