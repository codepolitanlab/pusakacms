# Database Version dengan Library Migrations

CodeIgniter telah memiliki library Migrations yang berfungsi mengatur managemen versi database aplikasi kita. Lebih lengkap tentang Library Migrations bisa dilihat di user guide Codeigniter bagian [Migration Class](http://ellislab.com/codeigniter/user-guide/libraries/migration.html).

## Alur Proses

Setiap kita membuat perubahan struktur data di dalam database, maka kita harus **merekam**nya supaya programmer lain bisa mendapatkan pembaharuan yang sama pada databasenya ketika dia mengupdate sistem. Tanpa itu, maka sistem kemungkinan besar akan mengalami error karena ada bagian pada databasenya yang hilang. Misalnya penambahan tabel, perubahan kolom pada tabel atau data statis yang wajib ada. **Rekaman** yang dimaksud adalah perubahan struktur database yang dibuat dalam bentuk query database manipulation semisal alter table, create table, dan lain sebagainya. **Rekaman** ini nantinya akan dijalankan pada sistem yang versinya lebih lama. Indikasi suatu sistem versinya lebih lama itu ditentukan dari perbandingan versi yang tercatat di database dengan catatan versi yang ada pada konfigurasi migrasi.

Misalkan begini. Di komputer lokal saya, aplikasi menjalankan versi 2. Angka tersebut didapatkan dari tabel migrations kolom version pada database di komputer saya. Kemudian saya mengupdate sistem (atau kalau pada contoh proyek yang menggunakan git, saya mem*pull* kode terbaru dari server ke komputer lokal saya), maka kode yang terbaru boleh jadi memiliki versi database yang terbaru. Hal itu diindikasikan dengan baris kode konfigurasi ```$config['migration_version'] = 2;``` di dalam file **jooglo/application/config/migration.php** yang menandakan bahwa kode terbaru adalah versi 2. Jika versi pada database saya menunjukkan angka 1, sedangkan sistem konfigurasi menunjukkan angka 2, berarti sistem (database) lama saya masih ada di state 1 dan harus diupdate ke versi 2. Maka saat itulah sistem akan menjalankan query update database yang sudah disediakan oleh programmer yang mengupdate struktur database ke versi 2.

## Set up

Untuk memulai menggunakan library migrations, terlebih dahulu kita harus buat table migrations di database jika belum ada. Strukturnya seperti ini:

	CREATE TABLE IF NOT EXISTS `jooglo_migrations` (
	  `version` int(11) NOT NULL,
	  PRIMARY KEY (`version`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;

Kemudian tambahkan satu baris data dengan nilai version = 0.

	INSERT INTO `jooglo_migrations` (`version`) VALUES (0);

Kemudian pastikan setting di file **jooglo/application/config/migration.php** sudah sesuai.

	$config['migration_enabled'] = TRUE;
	$config['migration_type'] = 'sequential';
	$config['migration_table'] = 'jooglo_migrations';
	$config['migration_version'] = 0;
	$config['migration_path'] = DEVPATH.'assets/migrations/';

## Merekam Perubahan Database

Ketika kita membuat perubahan database yang diperlukan oleh programmer lain, maka kita harus menyimpan perubahan tersebut dalam bentuk query yang dapat dijalankan oleh sistem. Kita dapat menggunakan libary DBForge dari CodeIgniter ataupun menggunakan query SQL. Contoh filenya seperti ini:

**001\_add\_blog.php**

	<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Migration_Add_blog extends CI_Migration {

		public function up()
		{
			$this->dbforge->add_field(array(
				'blog_id' => array(
					'type' => 'INT',
					'constraint' => 5,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'blog_title' => array(
					'type' => 'VARCHAR',
					'constraint' => '100',
				),
				'blog_description' => array(
					'type' => 'TEXT',
					'null' => TRUE,
				),
			));

			$this->dbforge->create_table('blog');
		}

		public function down()
		{
			$this->dbforge->drop_table('blog');
		}
	}

Setiap fase perubahan database mesti dicatat sebagai versi selanjutnya dari yang terakhir ada, yang diindikasikan oleh angka di awal nama file. Pada contoh di atas adalah 001 yang berarti ini adalah perubahan pertama database. Bila hendak membuat perubahan baru **setelah proses push update** ke server git, maka perubahan harus dibuat di dalam file baru dengan angka selanjutnya dari file migrasi yang sudah ada, misalnya 002\_deskripsi\_singkat.php. Nama class mesti diawali oleh Migration_ dan dilanjutkan oleh nama filenya, tanpa angka versi.

Class Migration mesti memiliki 2 method, yaitu method up() untuk upgrade dan down() untuk downgrade. Method up() akan dijalankan bila versi pada database lebih rendah dari versi pada konfigurasi sistem. Sebaliknya, versi down() akan dijalankan bila versi pada database lebih tinggi daripada versi pada sistem.

Satu hal lagi yang terpenting setelah merekam perubahan, adalah mencatat versi terbaru untuk perubahan tersebut pada konfigurasi migration. Misalnya file migration yang kita buat adalah versi 005, maka kita harus mengedit file **jooglo/application/config/migration.php** untuk baris ```$config['migration_version'] = 0;``` menjadi ```$config['migration_version'] = 5;```

## Menjalankan Migrasi

Jogglo memiliki class controller migrate yang berisi kode untuk mengecek versi dan menjalankan query migrasi. Untuk menjalankan proses migrasi, cukup panggil pada browser tautan berikut:
***http://localhost/devository/migrate***.