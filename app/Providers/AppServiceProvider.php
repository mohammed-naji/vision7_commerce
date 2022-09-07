<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        // dd(request()->ip());

        // $ip = request()->ip();
        // $ip = '100.36.44.0';
        // if($ip == '127.0.0.1') {
        //     $city = 'Gaza';
        // }else {
        //     $country = Http::get('http://www.geoplugin.net/json.gp?ip='.$ip)->json();
        //     $city = $country['geoplugin_city'];
        // }

        $city = 'gaza';

        // dd($_SERVER);

        $data = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=dccab945679f3bb9019537a309e05e47&units=metric')->json();

        $temp = $data['main']['temp'];
        $status = $data['weather'][0]['main'];
        $icon = $data['weather'][0]['icon'];

        $img = 'http://openweathermap.org/img/wn/'.$icon.'@2x.png';


        $weather = "Weather on $city: <img width='30' src='$img'> $temp $status";

        View::share('weather', $weather);
    }
}
