<?php

namespace Controlpad\Inventory;

class InventoriesTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        InventoryModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $sku = $faker->word.'-'.$faker->numerify($string = '##########');
            $item = array(
                'item_id' => $faker->numberBetween($min = 1, $max = 20),
                'quantity' => $faker->randomDigitNotNull,
                'warehouse_id' => $faker->numberBetween($min = 1, $max = 5),
                'address' => $faker->streetAddress,
                //'address_2' => $faker->secondaryAddress,
                //'city' => $faker->city,
                //'state' => strtoupper($faker->stateAbbr),
                //'zip' => $faker->postcode,
                'disabled' => $faker->boolean
            );
            InventoryModel::create($item);
        }
    }

}
?>