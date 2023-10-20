<?php

namespace App\Console\Commands;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new category';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $validator = Validator::make(['name' => $name], (new \App\Http\Requests\CategoryRequest)->rules());

        if ($validator->fails()) {
            $this->error('Validation failed. Please check the input.');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            Category::create(['name' => $name]);
            $this->info("Category '$name' created successfully");
        }
    }

}
