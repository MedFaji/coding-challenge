<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Product BY id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $product = Product::findOrFail($id);
        $product->delete();
        $this->info("Product with id '$id' deleted successfully");
    }
}
