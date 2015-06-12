<?php

namespace Controlpad\Inventory;

class VendorsTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        VendorModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $vendor = array(
                'name' => $faker->word,
                'email' => $faker->safeEmail,
                'phone'=>$faker->numerify($string = '##########'),
                'disabled' => $faker->boolean
            );
            $vendor = VendorModel::create($vendor);
            $address = array(
                'address_1' => $faker->streetAddress,
                'address_2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => strtoupper($faker->stateAbbr),
                'zip' => $faker->postcode
            );
            $vendor->address()->create($address);
        }
    }

}
?>
                                                  
