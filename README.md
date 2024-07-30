## Install Guide

-- DAILY BACKUP DATABASE
nyalakan schedule dengan command : "php artisan schedule:work" untuk ngetes commandnya "php artisan schedule:run". liat command apa aja di /app/console/Karnel.php
untuk menjalankan php artisan schedule:work di daemond biar pas close terminal tetep jalan, maka gunakan 'nohup' :
nohup php artisan schedule:work > /dev/null 2>&1 &
untuk liat statusnya :
pergi ke directory /v2 terus :
ps aux | grep 'php artisan schedule:work' | grep -v grep
untuk liat dia ngeksekusi didirekori mana : pwdx id_actionnya

-- TAMBAH OPTION

1. Tambah Provinsi, Kota, Kecamatan, Kelurahan dengan id 1 buat pilihan "LUAR NEGERI"
2. Tambah Provinsi, Kota, Kecamatan, Kelurahan dengan id 1 buat pilihan "TIDAK DIKETAHUI"

-- MELIHAT SELURUH EVENT SCHEDULER
SELECT EVENT_NAME, EVENT_SCHEMA, EVENT_DEFINITION, EVENT_BODY, EXECUTE_AT, INTERVAL_VALUE, INTERVAL_FIELD, STARTS, ENDS, STATUS
FROM information_schema.EVENTS;

-- HAPUS SCHEDULER
DROP EVENT IF EXISTS `coba2`;

-- CHECK EVENT SHEDULER AKTIF ATAU TIDAK
SHOW VARIABLES LIKE 'event_scheduler';

-- AKTIFKAN EVENT SCHEDULER
SET GLOBAL event_scheduler = ON;

2. UBAH ONLY_FULL_GROUP_BY
   config/database.php
   di server uncommand kode ini :
   'modes' => [
   // 'ONLY_FULL_GROUP_BY', // Disable this to allow grouping by one column
   'STRICT_TRANS_TABLES',
   'NO_ZERO_IN_DATE',
   'NO_ZERO_DATE',
   'ERROR_FOR_DIVISION_BY_ZERO',
   'NO_AUTO_CREATE_USER',
   'NO_ENGINE_SUBSTITUTION'
   ],
