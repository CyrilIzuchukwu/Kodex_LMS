<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Course;
use Auth;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share with all views
        View::composer('*', function ($view) {
            $this->shareUserData($view);
            $this->shareCommonData($view);
            $this->shareCartCountData($view);
        });
    }

    /**
     * @param $view
     * @return void
     */
    protected function shareCartCountData($view): void
    {
        $view->with([
            'cartCount' => CartItem::where('user_id', Auth::id())->count(),
        ]);
    }

    /**
     * @param $view
     * @return void
     */
    protected function shareCommonData($view): void
    {
        $view->with([
            'instructorAssignedCourses' => Course::orderBy('title')
                ->get(),
        ]);
    }

    /**
     * Share user data with the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    protected function shareUserData(\Illuminate\View\View $view): void
    {
        try {

            // Initialize default avatar
            $avatar = asset('dashboard_assets/images/client/default.png');

            // Check if the user is authenticated
            if (Auth::check()) {
                $user = Auth::user();

                // Check if profile and profile_photo_path exist
                if ($user->profile && $user->profile?->profile_photo_path) {
                    $avatar = $user->profile?->profile_photo_path;
                }
            }

            // Share avatar with the view
            $view->with(compact('avatar'));
        } catch (Exception $e) {
            // Log error and set a fallback avatar
            logger()->error('ViewComposer Error: ' . $e->getMessage());
            $avatar = asset('dashboard_assets/images/client/default.png');
            $view->with(compact('avatar'));
        }
    }
}
