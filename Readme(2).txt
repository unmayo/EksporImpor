File ini memuat data data untuk percobaan news cara kerjanya adalah saat gambar dan text di tekan maka akan memuat link. cukup simpel.

seblum memaikai harus memiliki database dengan nama test
jika tidak mau database bernama test maka buka `koneksi.php`
lalu ubah di line ke 5:
$db = "test";
ubah `test` sesuai nama database anda
jika sudah ada data basenya

lalu input ini di bagian SQL

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255),
    text VARCHAR(255),
    link VARCHAR(255),
    date DATE
);

jika sudah buka xammp dan nyalakan apache dan MySQL

lalu tulis alamat `localhost/test` di broser pilihan.

-Adib

