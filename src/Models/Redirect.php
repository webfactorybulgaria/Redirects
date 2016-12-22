<?php

namespace TypiCMS\Modules\Redirects\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;

class Redirect extends Base
{
    protected $fillable = [
        'alias',
    ];

    protected $appends = [];

    /**
     * The default route for back office.
     *
     * @var string
     */
    protected $route = 'redirects';

    /**
     * Get all of the owning redirectable models.
     */
    public function redirectable()
    {
        return $this->morphTo();
    }

}
