
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 👈 إضافة هذا السطر في الأعلى

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
                                                                // 🔒 إجبار لارافيل على استخدام HTTPS دائماً على سيرفر Render أو الإنتاج
                                                                        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
                                                                                    URL::forceScheme('https');
                                                                                            }
                                                                                                }
                                                                                                }