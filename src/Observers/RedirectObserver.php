<?php

namespace TypiCMS\Modules\Redirects\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Redirects\Models\Redirect;
use TypiCMS\Modules\Translations\Models\Translation;
use Redirects;

class RedirectObserver
{
    /**
     * On save, process redirects.
     *
     * @param Model $model eloquent
     *
     * @return mixed false or void
     */
    public function saved(Model $model)
    {   
        if ($model->arrRedirects) {
            $this->syncRedirects($model, $model->arrRedirects);
        }
    }

    /**
     * Sync redirects for model.
     *
     * @param Model $model
     * @param array $redirects
     *
     * @return void
     */
    protected function syncRedirects(Model $model, array $redirects)
    {
        // Create or add redirects
        $model->redirects()->delete();

        foreach($redirects as $key => $redirect) {
            $redirect = rtrim(trim($redirect),'/');

            if(!empty($redirect)) {
                if (!method_exists($model, 'redirects')) {
                    Log::info('Model doesn’t have a method called redirects');
                    break;
                }
                if (substr($redirect, 0, 1) !== '/') $redirect = '/'.$redirect;

                if (!Redirect::where('alias', $redirect)->first()) {
                    $redirectModel = new Redirect();
                    $redirectModel->alias = $redirect;

                    $model->redirects()->save($redirectModel);
                }
                else {
                    Log::info('Alias already exists');
                }
            }
        }
    }
}
