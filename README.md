# payment

# setup laragon
1. https://sobatcoding.com/articles/cara-install-dan-menggunakan-laragon

# setup postman
1. https://learning.postman.com/docs/getting-started/installation/installation-and-updates/

# collection postman
1. import collection postman yang tersedia pada project ini

# running app
1. create database payment di mysql
2. create table transaction di db payment (sql create ada di folder sql/transaction.sql)
3. create seed pada table transaction (seed ada di folder sql)
4. check transaction / check payment bisa menggunakan url (http://payment-detik.test:8081/payment/check) (gunakan bearer pada postman yang di ambil dari config/token.php)
5. post transaction / insert transaction bisa menggunakan url (http://payment-detik.test:8081/payment) (gunakan bearer pada postman yang di ambil dari config/token.php)
6. update transaction menggunakan PHP-CLI , buka terminal dan arahkan pada path c/laragon/www/payment lalu exec cli berikut \n
   \n php .\controllers\update_payment_cli.php {references_id} {payment_status}
   \n example : php .\controllers\update_payment_cli.php TR-20240328-001 1
7. payment status bisa di lihat pada folder shared/constans.php
