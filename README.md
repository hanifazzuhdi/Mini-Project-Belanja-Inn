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
4. Jalankan factory dengan langkah-langkah berikut :
    ```bash
     ketik php artisan tinker
     tulis perintah factory(App\User::class, 5)->create()
     selanjutnya factory(App\Shop::class, 3)->create()
     terakhir factory(App\Product::class, 15)->create()
   ```
(Perintah ini dilakukan untuk membuat data dummy pada project).
