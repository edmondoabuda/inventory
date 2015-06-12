<?php

namespace Controlpad\Inventory;

class ItemsTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        ItemModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $sku = $faker->word.'-'.$faker->numerify($string = '##########');
            $item = array(
                'name' => $faker->word,
                'weight' => $faker->randomDigitNotNull,
                'volume' => $faker->randomDigitNotNull,
                'inventory_number' => $sku,
                'mfg_sku' => $sku,
                'disabled' => $faker->boolean
            );
            ItemModel::create($item);
        }
    }

}
?>