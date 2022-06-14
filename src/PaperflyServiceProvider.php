<?php
namespace Wddyousuf\Paperfly;
use Illuminate\Support\ServiceProvider;
use Wddyousuf\Paperfly\Provider\PaperflyCourier;

class PaperflyServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/Paperfly.php' => config_path('paperfly.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('PaperflyCourier', function () {
            return new PaperflyCourier();
        });
    }
}