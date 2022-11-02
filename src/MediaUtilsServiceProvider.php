<?php

namespace Foxws\MediaUtils;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MediaUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-media-utils')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(MediaUtils::class, fn () => new MediaUtils());
        $this->app->bind('media-utils', MediaUtils::class);
    }
}
