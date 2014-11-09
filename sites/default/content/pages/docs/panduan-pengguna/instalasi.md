{: title :} Instalasi
{: content :}
## Komputer Lokal

Kamu perlu komputer yang terinstal XAMPP/WAMP di Windows atau LAMP di Linux atau MAMP di MacOS, atau aplikasi web server lainnya. Intinya PusakaCMS hanya memerlukan Web server (Apache2 atau web server lain) dan PHP 5.3.x. 

- Download *source code* PusakaCMS dari halaman [{{ func.site_url }}download]({{ func.site_url }}download)
- buat folder di localhost dengan nama sesuai keinginanmu, misalnya `pusaka/`
- Ekstrak semua file yang ada di dalam file kompresi PusakaCMS ke folder `pusaka/`
- Buka file `conf.php` kemudian ganti konfigurasi sesuai dengan kebutuhanmu
- PusakaCMS sudah dapat langsung diakses langsung dari browser dengan alamat `http://localhost/pusaka/`
	
## Server Hosting

Kamu bisa langsung mengupload file PusakaCMS ke server hostingmu. Caranya tidak jauh berbeda dengan pemasangan di komputer lokal. Tinggal ekstrak semua file PusakaCMS ke dalam folder `public_html/` atau `www/`, ganti konfigurasi di dalam file `conf.php` sesuai kebutuhan, dan website Kamu sudah dapat diakses melalui nama domain yang sudah terpasang di hostinganmu.

#### Catatan:

Terutama bila kamu menggunakan komputer berbasis dengan sistem operasi Linux atau MacOS, atau Kamu menguploadnya ke hostingan, pastikan folder `content/` dan semua subfolder berserta filenya diset permissionnya ke `666` atau `777` terlebih dahulu.