{: title :} Instalasi di Komputer Lokal
{: slug :} instalasi-di-komputer-lokal
{: parent :} docs/panduan-pengguna
{: content :} Kamu perlu komputer yang terinstal XAMPP/WAMP di Windows atau LAMP di Linux atau MAMP di MacOS, atau aplikasi web server lainnya. Intinya PusakaCMS hanya memerlukan Web server (Apache2 atau web server lain) dan PHP 5.3+

- Download *source code* PusakaCMS versi terbaru dari halaman [http://pusakacms.org/download](http://pusakacms.org/download)
- buka folder localhost (biasanya folder htdocs/ atau www/ tergantung aplikasi server yang digunakan) dan buat folder baru dengan nama sesuai keinginanmu, misalnya `pusakacms/`
- Ekstrak semua file yang ada di dalam file kompresi PusakaCMS ke folder `pusakacms/`
- PusakaCMS sudah dapat langsung diakses langsung dari browser dengan alamat `http://localhost/pusakacms/`. Pastikan server Apache sudah dinyalakan.

#### Catatan:

Terutama bila kamu menggunakan komputer berbasis dengan sistem operasi Linux atau MacOS, atau Kamu menguploadnya ke hostingan, pastikan folder `content/` dan semua subfolder berserta filenya diset permissionnya ke `755` atau `777` terlebih dahulu.
