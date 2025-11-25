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
                'icon' => 'fas fa-fw fa-user',
            ]);
            $event->menu->add([
                'text' => 'Devolutivas',
                'url' => 'reports',
                'icon' => 'fas fa-fw fa-table',
                'active' => ['reports*'],
            ]);
            $event->menu->add([
                'text' => 'Turmas',
                'url' => 'classes',
                'icon' => 'fas fa-fw fa-book',
                'active' => ['classes*'],
            ]);
            if ($user->role == 'admin') {
                $event->menu->add([
                    'text' => 'Oficineiros',
                    'url' => 'instructors',
                    'icon' => 'fas fa-fw fa-users',
                    'active' => ['instructors*'],
                ]);
            }
        });   
    }
}
