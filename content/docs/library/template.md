# Template Library

## view($view_file, $data = array(), $return = false)

Fungsi ini yang menjadi fungsi utama untuk merender halaman, menggantikan `$this->load->view()` pada metode konvensional.

#### parameter: 

**$view_file** : (string) file view yang diload

**$data** : (array) data yang hendak disisipkan di dalam view (optionl)

**$return** : (bool) true : view dikembalikan dalam bentuk string; false : langsung dioutput (optional)


## set_partial($name, $view, $data = array())

Fungsi ini meload suatu file view sebagai partial. File view partial akan dicari di dalam folder `views/` pada theme aktif dan kemudian theme default. Anda dapat menyimpannya di dalam subfolder `views/partials/` jika mau, tapi tidak dibatasi demikian untuk tujuan fleksibilitas. Jika file partial akan disimpan hanya di dalam folder `views/partials/` misalnya, maka Anda harus mengeset folder partial dengan fungsi `set_partial_folder('partials')` agar nama folder tersebut tidak perlu disertakan lagi dalam pemanggilan view. Setelah diload, partial tersebut dapat disisipkan di dalam layout atau partial lain dengan sintaks `$template['partials']['nama_partial']`.

#### parameter:

**$name** : (string) nama indeks partial

**$view** : (string) file view yang diload sebagai partial

**$data** : (array) data yang hendak disisipkan di dalam view (optional)


## inject_partial($name, $string, $data = array())

Fungsi ini sama seperti `set_partial()`, kecuali parameter kedua diisi oleh string view yang akan dijadikan partial.

#### parameter:

**$name** : (string) nama indeks partial

**$string** : (string) string yang akan dijadikan konten partial

**$data** : (array) data yang hendak disisipkan di dalam view (optional)


## set\_layout($view, $layout_subdir = '')

Fungsi ini untuk mengeset layout mana yang akan digunakan untuk halaman yang akan ditampilkan. File view layout akan dicari di dalam folder `views/layouts/` pada theme aktif dan kemudian theme default.

#### parameter:

**$view** : (string) nama view layout yang akan digunakan

**$layout_subdir** : (string) nama subfolder yang membuat layout tsb bila ada (optional) 


## set($name, $value)

Fungsi ini membantu kita untuk menyisipkan suatu nilai untuk digunakan di dalam view. kegunaannya serupa dengan menyisipkan data melalui variabel array `$data` pada parameter kedua fungsi view. Nilai sudah yang disisipkan dengan menggunakan kedua cara tersebut dapat diakses pada view utama, view partial ataupun layout.

#### parameter:

**$name** : (string) nama variabel

**$value** : (variant) nilai variabel


## title($param1, $param2, ..)

Fungsi ini untuk mengeset judul halaman. Setelah diset, nilai title dapat dipanggil di dalam view dengan sintaks `$template['title']`. Parameter fungsi berjumlah satu atau lebih, dan saat dicetak setiap nilai parameter akan dipisah oleh separator yang sudah diset di dalam file **application/config/template.php**. 

#### parameter:

**$param1, $param2, ..** : (string) value judul halaman


## set_metadata($name, $content, $type = 'meta')

Fungsi ini untuk mengeset metadata. Setelah diset, metadata dapat dipanggil dengan sintaks `$template['metadata']`.

#### parameter:

**$name** : (string) nama metadata: keywords, description, dll

**$content** : (string) konten metadata

**$type** : (string) tipe metadata, 'meta' atau 'link' (optional)


## prepend_metadata($line)

Fungsi ini untuk memasang ekstra tag seperti javascipt, css, meta tags, dll sebelum data head lain

#### parameter:

**$line** : (string) baris tag yang ingin ditambahkan


## append_metadata($line)

Fungsi ini untuk memasang ekstra tag seperti javascipt, css, meta tags, dll setelah data head lain

#### parameter:

**$line** : (string) baris tag yang ingin ditambahkan


## set_js($file)

Fungsi ini untuk memasang tag script js yang ada pada pada folder `js` pada theme atau module. Untuk menampilkan daftar tag script js yang sudah diset, gunakan sintaks `$template['js']`.

#### parameter:

**$file** : (string) nama file js, dahului dengan 'namamodule::' untuk mengambil js dari dalam module


## set_css($file)

Fungsi ini untuk memasang tag link css yang ada pada folder `css` pada theme atau module. Untuk menampilkan daftar tag link css yang sudah diset, gunakan sintaks `$template['css']`.

#### parameter:

**$file** : (string) nama file css, dahului dengan 'namamodule::' untuk mengambil js dari dalam module


## set_breadcrumb($name, $uri = '')

Fungsi ini untuk mengeset breadcrumb suatu halaman. Setiap kali diset, breadcrumb akan ditambahkan pada tumpukan array.

#### parameter:

**$name** : (string) nama judul breadcrumb

**$uri** : (string) URI untuk tautan breadcrumb (optional)


## set_theme($theme)

Fungsi ini untuk mengeset theme mana yang akan digunakan.

#### parameter:

**$theme** : (string) nama folder theme


## set\_layout_folder($folder)

Fungsi ini untuk mengeset di folder mana file-file layout harus disimpan (relatif dari folder `views/`).

#### parameter:

**$folder** : (string) nama folder layout, tanpa slash. Secara default bernilai `'layouts'`.


## set\_partial_folder($folder)

Fungsi ini untuk mengeset di folder mana file-file partial harus disimpan (relatif dari folder `views/`).

#### parameter:

**$folder** : (string) nama folder partial, tanpa slash


## get_theme()

Fungsi ini untuk memanggil nama theme yang sedang aktif

## get\_theme_path()

Fungsi ini untuk memanggil path theme yang sedang aktif


## theme_exists($theme)

Fungsi ini untuk mengecek apakah theme yang dimaksud ada pada sistem

#### parameter:

**$theme** : nama theme yang dicek keberadaannya


## get\_theme_layouts($theme)

Fungsi ini untuk mengambil daftar nama layout yang tersedia

#### parameter:

**$theme** : nama theme yang diambil daftar layoutnya


## layout_exists($layout)

Fungsi ini untuk mengecek apakah layout yang dimaksud ada pada sistem

#### parameter:

**$layout** : nama theme yang dicek keberadaannya