<?php

namespace Controlpad\Inventory;

class ProductsTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        ProductModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $product = array(
                'name' => $faker->sentence($nbWords = 6),
                'blurb' => $faker->text,
                'description' => $faker->text,
                'price_retail' => $faker->numberBetween($min = 105, $max = 200),
                'price_rep' => $faker->numberBetween($min = 50, $max = 100),
                'price_cv' => $faker->numberBetween($min = 50, $max = 100),
                'weight' => $faker->numberBetween($min = 50, $max = 100),
                'volume' => $faker->numberBetween($min = 50, $max = 100),
                'quantity' => $faker->numberBetween($min = 1, $max = 100),
                'disabled' => $faker->boolean,
                'sku' => $faker->unique()->randomNumber($min = 10000, $max = 100000)
            );
            ProductModel::create($product);
        }
    }

}
?>
                                                  
