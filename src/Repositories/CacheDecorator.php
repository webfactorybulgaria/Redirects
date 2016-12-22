<?php

namespace TypiCMS\Modules\Redirects\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;
use Illuminate\Support\Facades\Request;

class CacheDecorator extends CacheAbstractDecorator implements RedirectInterface
{
    public function __construct(RedirectInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get single model by alias.
     *
     * @param string $alias of model
     * @param array  $with
     *
     * @return object object of model information
     */
    public function byAlias($alias)
    {
        // Build the cache key, unique per model alias
        $cacheKey = md5(config('app.locale').'byAlias'.$alias.serialize(Request::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->byAlias($alias);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;
    }
}
