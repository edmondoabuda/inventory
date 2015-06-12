<?php

namespace Controlpad\Inventory;

class WarehouseTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        WarehouseModel::truncate();

        for($i = 1; $i <= 5; $i++) {
            $warehouse = array(
                'name' => 'w'.$i.'-'.$faker->word,
                'disabled' => $faker->boolean
            );
            $warehouse = WarehouseModel::create($warehouse);
            $address = array(
                'address_1' => $faker->streetAddress,
                'address_2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => strtoupper($faker->stateAbbr),
                'zip' => $faker->postcode
            );
             $warehouse->address()->create($address);
        }
    }

}
?>