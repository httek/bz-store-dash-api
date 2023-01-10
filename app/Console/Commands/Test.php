<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Product;
use App\Services\TokenService;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd(
            Product::create(['name' => 'Test'])
        );
    }
}
