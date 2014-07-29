# Frontend Theme

Sistem theme diatur oleh library template. Secara default semua theme disimpan di dalam folder **application/themes/**. Struktur folder untuk theme adalah sebagai berikut:

	themes/
	| default/
	  | css/
	  | img/
	  | js/
	  | views/
	    | layouts/
	      | default.php
	      | left_sidebar.php
	      | right_sidebar.php
	    | pages/
	      | files/
	        | index.php
	    | partials/
	      | header.php
	      | sidebar.php
	      | footer.php

Dalam setiap pemanggilan file view, library template pertama-tama akan mencari file views pada folder **themes/[nama_themes]/views/** terlebih dahulu. Apabila file yang dimaksud tidak ditemukan, maka library template akan mencari di views utama MVC. 

[unfinished]