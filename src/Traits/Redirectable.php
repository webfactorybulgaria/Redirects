<?php

namespace TypiCMS\Modules\Redirects\Traits;

trait Redirectable
{
    protected $redirectsDirty = false;
    public $arrRedirects = [];


    /**
     * Boot the trait.
     */
    public static function bootRedirectable()
    {
        //
    }

    /**
     * A model can have redirects.
     */
    public function redirects()
    {
        return $this->morphMany('TypiCMS\Modules\Redirects\Shells\Models\Redirect', 'redirectable')->orderBy('id');
    }

    /**
     * A redirects getter.
     */
    public function getRedirectsAttribute()
    {
        return implode("\n", $this->redirects()->get()->pluck('alias')->all());
    }

    /**
     * A redirects getter.
     */
    public function setRedirectsAttribute($value)
    {
        $value = str_replace("\r", '', $value);
        if ($this->redirects != $value) {
            $this->arrRedirects = preg_split('/\r?\n/', $value);
            $this->redirectsDirty = true;
        }
        //return implode("\n", $this->redirects()->get()->pluck('alias')->all());
    }

    public function getDirty()
    {
        $dirty = parent::getDirty();
        if ($this->redirectsDirty) {
            $dirty[$this->getKeyName()] = $this->{$this->getKeyName()};
        }

        return $dirty;
    }

}
