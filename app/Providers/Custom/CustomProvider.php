<?php


namespace App\Providers\Custom;


use App\Contracts\AuthServiceInterface;
use App\Contracts\BoardServiceInterface;
use App\Contracts\CardServiceInterface;
use App\Contracts\ListServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Services\AuthService;
use App\Services\BoardService;
use App\Services\CardService;
use App\Services\ListService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class CustomProvider extends ServiceProvider
{

    /**
     * Register the Service
     */
    public function register()
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(BoardServiceInterface::class, BoardService::class);
        $this->app->bind(CardServiceInterface::class, CardService::class);
        $this->app->bind(ListServiceInterface::class, ListService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}
