<?php

namespace Foxws\MediaUtils;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MediaUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-media-utils')
            ->hasConfigFile('media-utils');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(MediaUtils::class, fn () => new MediaUtils());
        $this->app->bind('media-utils', MediaUtils::class);
    }
}
