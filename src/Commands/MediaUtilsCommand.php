<?php

namespace Foxws\MediaUtils\Commands;

use Illuminate\Console\Command;

class MediaUtilsCommand extends Command
{
    public $signature = 'laravel-media-utils';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
