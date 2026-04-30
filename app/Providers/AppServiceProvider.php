<?php


namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

public function boot(): void
{
View::composer('*', function ($view) {

    if(auth()->check()){
        $unread = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    } else {
        $unread = 0;
    }

    $view->with('unreadNotifications', $unread);
});
}
}