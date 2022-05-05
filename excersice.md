1. Susikurti per migracija table items, kuris turetu tokius column’sus:

    - id autoincrement uniq
    - name varchar (100) not null
    - sku varchar (20) not null uniq
    - description text null
    - price float default 0
    - quantity int 0
    - active bool
    - created_at
    - updated_at
    
````shell
php artisan make:migration ...
php artisan migrate
````

2. Uzpildyti fake data items lenta, tam panaudoti faker’i

````shell
php artisan db:seed --class=...
````

3. Su artisan komanda sukurkite ItemController

````shell
php artisan make:controller ...
````

3. Susikurti items list’o atvaizdavimo puslapi

4. Susikurti vieno items’o atvaizdavimo puslapi

5. Susikurti naujo items pridejimo puslapi, panaudoti validacijas (galite naudoti basic validacijas, rekomenduojama FormRequest validacija)

6. Susikurti item update puslapi (panaudokite validacijas)

7. Prideti prie items list’o trinimo mygtuka
