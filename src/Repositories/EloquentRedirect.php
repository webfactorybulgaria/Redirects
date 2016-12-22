<?php

namespace TypiCMS\Modules\Redirects\Repositories;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentRedirect extends RepositoriesAbstract implements RedirectInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get single model by Alias.
     *
     * @param string $alias alias
     * @param array  $with related tables
     *
     * @return mixed
     */
    public function byAlias($alias)
    {
        $model = $this->make()
            ->where('alias', '=', $alias)
            ->first();

        return $model;
    }
}
