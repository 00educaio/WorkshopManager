<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = Auth::user();

            $event->menu->add('NAVEGAÇÃO PRINCIPAL');
            $event->menu->add([
                'text' => 'Perfil',
                'url' => 'profile',
            ]);
            $event->menu->add([
                'text' => 'Devolutivas',
                'url' => 'reports',
            ]);
            $event->menu->add([
                'text' => 'Turmas',
                'url' => 'classes',
            ]);
            if ($user->role == 'admin') {
                $event->menu->add([
                    'text' => 'Ver Oficineiros',
                    'url' => 'instructors',
                ]);
            }
        });   
    }
}
