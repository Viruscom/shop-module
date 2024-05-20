<?php

    namespace Modules\Shop\Providers;

    use Config;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\ServiceProvider;
    use Modules\Shop\Console\RequestStrickerProducts;
    use Modules\Shop\Console\UpdateCurrencyRates;
    use Modules\Shop\Http\Middleware\SetCookieMiddleware;
    use Modules\Shop\View\Components\Front\Basket\BasketSummary;
    use Modules\Shop\View\Components\Front\Basket\StepOne\BasketStepOneFavIcon;
    use Modules\Shop\View\Components\Front\Basket\StepOne\BasketStepOneProductAmount;
    use Modules\Shop\View\Components\Front\Basket\StepOne\BasketStepOneQuantity;
    use Modules\Shop\View\Components\Front\Basket\StepOne\BasketStepOneUnitPrice;

    class ShopServiceProvider extends ServiceProvider
    {
        /**
         * @var string $moduleName
         */
        protected $moduleName = 'Shop';

        /**
         * @var string $moduleNameLower
         */
        protected $moduleNameLower = 'shop';

        /**
         * Boot the application events.
         *
         * @return void
         */
        public function boot()
        {
            Blade::component('shop::front.basket.step_one.basket_step_one_favicon', BasketStepOneFavIcon::class);
            Blade::component('shop::front.basket.step_one.basket_step_one_unit_price', BasketStepOneUnitPrice::class);
            Blade::component('shop::front.basket.step_one.basket_summary', BasketSummary::class);
            Blade::component('shop::front.basket.step_one.basket_step_one_quantity', BasketStepOneQuantity::class);
            Blade::component('shop::front.basket.step_one.basket_step_one_product_amount', BasketStepOneProductAmount::class);
            $this->commands([UpdateCurrencyRates::class]);
            $this->registerTranslations();
            $this->registerConfig();
            $this->registerViews();
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
            $this->app['router']->aliasMiddleware('set.sbuuid', SetCookieMiddleware::class);
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations()
        {
            $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            } else {
                $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            }
        }

        /**
         * Register config.
         *
         * @return void
         */
        protected function registerConfig()
        {
            $this->publishes([
                                 module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
                             ], 'config');
            $this->mergeConfigFrom(
                module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
            );
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews()
        {
            $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

            $sourcePath = module_path($this->moduleName, 'Resources/views');

            $this->publishes([
                                 $sourcePath => $viewPath
                             ], ['views', $this->moduleNameLower . '-module-views']);

            $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
        }

        private function getPublishableViewPaths(): array
        {
            $paths = [];
            foreach (Config::get('view.paths') as $path) {
                if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                    $paths[] = $path . '/modules/' . $this->moduleNameLower;
                }
            }

            return $paths;
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            $this->app->register(RouteServiceProvider::class);
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides()
        {
            return [];
        }
    }
