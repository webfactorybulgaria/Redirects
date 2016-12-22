<?php

namespace TypiCMS\Modules\Redirects\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TypiCMS\Modules\Redirects\Facades\Facade as Redirect;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;

class CheckRedirect
{
    public function getRedirectURIPageTranslation($model)
    {
        return $model->page->uri($model->locale);
    }

    public function getRedirectURICategory($model)
    {
        $pageModel = TypiCMS::getPageLinkedToModule(str_plural('project'));
        return $pageModel->uri($model->locale) . '/'.$model->slug;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($redirect = Redirect::byAlias('/'.request()->path())) {
            if ($model = $redirect->redirectable) {
                $modelClassName = class_basename($model);
                if (method_exists($model, 'getRedirectURI')) {
                    $uri = $model->getRedirectURI();
                } else if (method_exists($this, 'getRedirectURI' . $modelClassName)) {
                    $uri = $this->{'getRedirectURI' . $modelClassName}($model);
                } else if (strpos($modelClassName, 'Translation')) {
                    $owner = $model->owner;
                    if (method_exists($owner, 'uri')) {
                        $uri = $owner->uri($model->locale);
                    }
                } else if (method_exists($model, 'uri')) {
                    $uri = $model->uri();
                }

                if ($uri) {
                    return response()
                        ->redirectTo('/' . $uri, 301)
                        ->header('X-A4-Redirect', $redirect->id);                       
                }
            }
 
        }

        return $next($request);
    }
}
