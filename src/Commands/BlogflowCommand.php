<?php

namespace irajul\Blogflow\Commands;

use Illuminate\Console\Command;

class BlogflowCommand extends Command
{
    public $signature = 'blogflow';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
