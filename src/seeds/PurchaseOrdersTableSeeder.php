<?php

namespace Controlpad\Inventory;

class PurchaseOrdersTableSeeder extends DatabaseSeeder 
{

    public function run()
    {
        $faker = $this->getFaker();
        PurchaseOrderModel::truncate();

        for($i = 1; $i <= 20; $i++) {
            $purchaseorder = array(
                'vendor_id' => $faker->numberBetween($min = 1, $max = 20),
                'ordered_on' => $faker->date($format = 'Y-m-d', '+1 month'),
                'received_on' => $faker->date($format = 'Y-m-d', '+2 months'),
                'due_on' => $faker->date($format = 'Y-m-d', '+3 months'),
                'disabled' => $faker->boolean
            );
            PurchaseOrderModel::create($purchaseorder);
        }
    }

}
?>