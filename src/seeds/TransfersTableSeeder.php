<?php

namespace Controlpad\Inventory;

class TransfersTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        TransferModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $w1 = $faker->numberBetween($min = 1, $max = 5);
            $w2 = $faker->numberBetween($min = 1, $max = 5);
            
            $transfer = array(
                'warehouse_id_from' => $w1,
                'warehouse_id_to' => $w2,
                'qty' => $faker->randomDigitNotNull,
                'item_id' => $faker->numberBetween($min = 1, $max = 20),
                'disabled' => $faker->boolean
            );
            try{
                TransferModel::create($transfer);
            }
            catch(\PDOException $e)
            {
                $i = 20;    
            }
        }
    }

}
?>
      