<?php

namespace TypiCMS\Modules\Redirects\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\RepositoryInterface;

interface RedirectInterface extends RepositoryInterface
{
	/**
     * Get single model by Alias.
     *
     * @param string $alias alias
     * @param array  $with related tables
     *
     * @return mixed
     */
    public function byAlias($alias);
}
