## Usage

1. sesuaikan konfigurasi pada file .env nya :
```bash
    - dbname = mini_project
    - dbhost = (sesuaikan)
    - dbpass = (sesuaikan)
```
2. Migrasi table yang sudah dibuat dengan 
```bash
php artisan migrate
```
3. jalankan seeder yang dibuat untuk Category dan Role dengan perintah 
```bash
php artisan db:seed
```
(Perintah ini dilakukan untuk membuat data dummy pada project).

```bash
Diagram Database Link:
https://drawsql.app/pondok-it/diagrams/mini-project
```

Status pada tabel order dan carts  :
```bash
 - 0 = ditambahkan ke keranjang belum dicheckout
 - 1 = sudah dicheckout
 - 2 = sudah dikonfirmasi oleh penjual untuk dikirim
 - 3 = sudah diterima pembeli
```
