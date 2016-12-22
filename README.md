# Redirects

## Installation
`composer require webfactorybulgaria/redirects`

Add this line to `app/Http/Kernel.php`
 \TypiCMS\Modules\Redirects\Shells\Http\Middleware\CheckRedirect::class,

Add this to the Model:
    use TypiCMS\Modules\Redirects\Shells\Traits\Redirectable;
    ...
    use Redirectable;

Add this to the admin form view:
 {!! TranslatableBootForm::textarea(trans('validation.attributes.redirects'), 'redirects') !!}


This module is part of [Admintool4](https://github.com/webfactorybulgaria/Base), a multilingual CMS based on Laravel 5.
