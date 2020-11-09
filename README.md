- Petunjuk Clone

1. gitclone repo ini
2. sesuaikan konfigurasi pada file .env nya :
    - dbname = mini_project
    - dbhost = (sesuaikan)
    - dbpass = (sesuaikan)
3. Migrasi table yang sudah dibuat dengan php artisan migrate
4. jalankan seeder yang dibuat untuk Category dan Role dengan perintah php artisan db:seed
5. Jalankan factory dengan langkah-langkah berikut :
    1. ketik php artisan tinker
    2. tulis perintah factory(App\User::class, 5)->create()
    3. selanjutnya factory(App\Shop::class, 3)->create()
    4. terakhir factory(App\Product::class, 15)->create()
   (Perintah ini dilakukan untuk membuat data dummy pada project).
