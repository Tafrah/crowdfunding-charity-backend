<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\FiltersServiceProvider::class,
    App\Providers\DashboardServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\PaymentServiceProvider::class,
    Laravel\Socialite\SocialiteServiceProvider::class,
    App\Providers\SocialiteServiceProvider::class,
];
