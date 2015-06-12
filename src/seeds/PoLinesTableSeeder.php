<?php

namespace Controlpad\Inventory;

class PoLinesTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        PoLineModel::truncate();
        for($i = 1; $i <= 20; $i++) {
            $poline = array(
            'purchaseorder_id' => $i,
            'item_id' => $faker->numberBetween($min = 1, $max = 20),
            'qty' => $faker->randomDigitNotNull,
            'disabled' => $faker->boolean
            );
            try{
                PoLineModel::create($poline);
                $unique = true;
            }
            catch(\PDOException $e)
            {
                $i = 20;  
            }
        }
    }

}
?>