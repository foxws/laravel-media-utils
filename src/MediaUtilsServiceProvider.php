<?php

namespace Foxws\MediaUtils;

use Foxws\MediaUtils\Commands\MediaUtilsCommand;
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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-media-utils_table')
            ->hasCommand(MediaUtilsCommand::class);
    }
}
