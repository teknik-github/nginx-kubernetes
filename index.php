<?php
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Direktori tujuan untuk menyimpan file
$targetDirectory = '/mnt/nfs';

// Periksa apakah direktori dapat diakses
if (!is_dir($targetDirectory) || !is_writable($targetDirectory)) {
    die("Error: Direktori $targetDirectory tidak dapat diakses atau tidak memiliki izin menulis.");
}

// Fungsi untuk menangani upload file
function handleFileUpload($targetDirectory)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Periksa apakah ada kesalahan saat mengunggah
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "<p>Error: Terjadi masalah saat mengunggah file.</p>";
            return;
        }

        // Nama file tujuan
        $destination = $targetDirectory . '/' . basename($file['name']);

        // Pindahkan file yang diunggah ke lokasi tujuan
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo "<p>File berhasil disimpan di: $destination</p>";
        } else {
            echo "<p>Error: Gagal menyimpan file.</p>";
        }
    }
}

// Tangani upload file
handleFileUpload($targetDirectory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File ke /mnt/nfs bug</title>
</head>
<body>
    <h1>Upload File bug</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="file">Pilih file untuk diunggah:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>