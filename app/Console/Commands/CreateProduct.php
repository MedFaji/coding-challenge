<?php

namespace App\Console\Commands;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name} {description} {price}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name= $this->argument('name');
        $description = $this->argument('description');
        $price= $this->argument('price');

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price
        ];

        $validator = Validator::make($data, (new \App\Http\Requests\ProductRequest)->rules());

        if ($validator->fails()) {
            $this->error('Validation failed. Please check the input.');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            $product = Product::create($data);
            $this->info("Product created with name: $name, description: $description, price: $price");
        }
    }
}
