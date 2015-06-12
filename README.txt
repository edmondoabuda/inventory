Deployment Steps


1. clone
2. git checkout feature/inventory
3. composer install
4. composer update
5. assign virtualhost
6. chmod +R 777 app/storage
7. edit bootstrap/start.php
8. mkdir -p app/config/randy_local
9. cd app/config/randy_local
10. cp ../app.php .
11. cp ../database.php .
12. cp ..site.php .
13. modify debug to true in app.php
14. modify database.php with the right settings
15. modify site.php, both base_domain and domain entries
16. modify app.php, add to providers "Controlpad\Inventory\InventoryServiceProvider"
17. cd workbench/controlpad/inventory
18. composer install
19. composer update
20. go back to main directory (cd ../../..)
21. php artisan migrate
22. php artisan migrate --bench="controlpad/inventory" --database="controlpad-inventory"
23. php artisan config:publish --path="workbench/controlpad/inventory/src/config" controlpad/inventory
24. php artisan asset:publish --bench="controlpad/inventory"
25. php artisan db:seed
26. php artisan db:seed --class="Controlpad\Inventory\DatabaseSeeder"

========================================================     



A. Create a package

A.1. Verify composer file

composer validate

A.2. Working within the workbench to recreate the autoload files after new classes are made

composer dump-autoload

A.3. Creating migrations for a package

php artisan migrate:make create_inv_item_product_table --bench="controlpad/inventory"

B. Installing the package

B.1. Migration
Set the --bench for the Vendor/PackageName and --database for the right database connection to use

Example:
php artisan migrate --bench="controlpad/inventory" --database="controlpad-inventory"

B.2. Generate custom configuration files for a package

php artisan config:publish --path="workbench/controlpad/inventory/src/config" controlpad/inventory

B.3. Publish config for other vendor packages

php artisan config:publish thujohn/pdf --path="/workbench/controlpad/inventory/vendor/thujohn/pdf/src/config"

B.3. Publish assets to customize it later

php artisan asset:publish --bench="controlpad/inventory"

B.4. Seeding database

php artisan db:seed --class="Controlpad\Inventory\DatabaseSeeder"




