<?php

namespace App\Providers;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Image;
use App\Policies\ProductPolicy;
use App\Policies\ImagePolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        User::class => UserPolicy::class,
        Image::class => ImagePolicy::class,
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-product', function ($user, $product){
        //    return $user->id == $product->user_id || $user->role == 1;
        // });
        Gate::define('check-role', function ($user){
           return $user->role == 1 || $user->role == 2;
        });
    }
}
