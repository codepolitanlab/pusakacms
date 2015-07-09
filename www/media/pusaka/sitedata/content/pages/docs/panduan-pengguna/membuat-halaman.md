{: title :} Membuat Halaman
{: content :}
Semua file yang terkait dengan halaman disimpan di `content/pages/`. Folder ini berisi file `index.html` dan `nav.json` (untuk pengaturan navigasi).

**Format penamaan folder dan file:** 	
- Huruf non-kapital 	
- Spasi diganti _dash_ (strip); ex. `about-me`, `cara-pemesanan-luar-bandung` 	
- Secara _default_, nama folder atau file akan menjadi judul halaman yang ditampilkan pada area navigasi 	

* **Membuat halaman tanpa sub-halaman** 	
Buat file baru ( .md, .html, atau textile) di folder `pages/` 

* **Membuat halaman yang memiliki sub-halaman** 	
Sub-halaman terletak pada sebelah kiri halaman. Sub-halaman dapat memiliki sub lagi. 		
Buat folder baru di dalam folder `pages/` dengan nama sesuai dengan judul halaman 	
Sub-halaman dibuat di dalam folder baru tersebut 	
Sub-halaman berbentuk file

* **Merubah halaman tanpa sub-halaman menjadi halaman yang memiliki sub-halaman**	
Buat folder baru di `pages/` dengan nama sesuai dengan judul halaman 	
Pindahkan file halaman tanpa sub-halaman ke dalam folder tersebut, kemudian ganti namanya menjadi `index.html` 