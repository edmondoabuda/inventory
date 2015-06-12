<?php

namespace Controlpad\Inventory;

class DatabaseSeeder extends \Seeder {
    protected $faker;

    public function getFaker()
    {
        if(empty($this->faker)) {
            $this->faker = \Faker\Factory::create();
        }

        return $this->faker;
    }
    
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Eloquent::unguard();

         $this->call('Controlpad\Inventory\PoLinesTableSeeder');
         $this->call('Controlpad\Inventory\PurchaseOrdersTableSeeder');
         $this->call('Controlpad\Inventory\ItemProductsTableSeeder');
         $this->call('Controlpad\Inventory\InventoriesTableSeeder');
         $this->call('Controlpad\Inventory\ProductsTableSeeder');
         $this->call('Controlpad\Inventory\ItemsTableSeeder');
         $this->call('Controlpad\Inventory\VendorsTableSeeder');
         $this->call('Controlpad\Inventory\WarehouseTableSeeder');
         $this->call('Controlpad\Inventory\TransfersTableSeeder');
    }
    
    
}
?>
