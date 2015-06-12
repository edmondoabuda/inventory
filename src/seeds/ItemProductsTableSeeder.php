<?php

namespace Controlpad\Inventory;

class ItemProductsTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        ItemProductModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $w1 = $faker->numberBetween($min = 1, $max = 20);
            $w2 = $faker->numberBetween($min = 1, $max = 20);
            $transfer = array(
                'product_id' => $w1,
                'item_id' => $w2,
                'qty' => $faker->randomDigitNotNull,
               'disabled' => $faker->boolean
            );
            try{
                ItemProductModel::create($transfer);
            }
            catch(\PDOException $e)
            {
                $i = 20;    
            }
        }
    }

}
?>
      