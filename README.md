# Redirects

## Installation

`composer require webfactorybulgaria/redirects`

Add this to config/app.php

TypiCMS\Modules\Redirects\Shells\Providers\ModuleProvider::class,


`php artisan vendor:publish`

`php artisan migrate`


Add this line to `app/Http/Kernel.php` in the $middleware array

 \TypiCMS\Modules\Redirects\Shells\Http\Middleware\CheckRedirect::class,

Add this to the Model:

    use TypiCMS\Modules\Redirects\Shells\Traits\Redirectable;

    ...

    use Redirectable;

Add 'redirects' to the fillable array of the main model

Add 
- `use TypiCMS\Modules\Redirects\Shells\Observers\RedirectObserver;`

- `<Model>::observe(new RedirectObserver());` to the ModuleProvider

Add this to the admin form view:

 {!! TranslatableBootForm::textarea(trans('validation.attributes.redirects'), 'redirects') !!}


This module is part of [Admintool4](https://github.com/webfactorybulgaria/Base), a multilingual CMS based on Laravel 5.
