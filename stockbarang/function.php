<?php
session_start();

// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Menambah barang baru
if (isset($_POST['submit'])) {
    // Mengambil data dari form dan menghindari SQL Injection
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $stock = (int)$_POST['stock']; // Pastikan stock adalah integer

    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$namabarang', '$deskripsi', '$stock')");

    if ($addtotable) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Gagal menambahkan barang: ' . mysqli_error($conn);
        header('refresh:5; url=index.php');
        exit();
    }
}

// Menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = (int)$_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        header('Location: masuk.php');
        exit();
    } else {
        echo 'Gagal menambahkan barang masuk: ' . mysqli_error($conn);
        header('refresh:5; url=masuk.php');
        exit();
    }
}

// Barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = (int)$_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $kurangistocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock='$kurangistocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if ($addtokeluar && $updatestockkeluar) {
        header('Location: keluar.php');
        exit();
    } else {
        echo 'Gagal menambahkan barang keluar: ' . mysqli_error($conn);
        header('refresh:5; url=keluar.php');
        exit();
    }
}

// Update barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
    if ($update) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Gagal memperbarui barang: ' . mysqli_error($conn);
        header('refresh:5; url=index.php');
        exit();
    }
}

// Hapus barang
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if ($hapus) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Gagal menghapus barang: ' . mysqli_error($conn);
        header('refresh:5; url=index.php');
        exit();
    }
}

// Mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = isset($_POST['idmasuk']) ? $_POST['idmasuk'] : null;
    $deskripsi = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

    if (empty($idm)) {
        echo 'ID Masuk tidak ditemukan.';
        header('refresh:5; url=masuk.php');
        exit();
    }

    $lihatstok = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstok);
    $stockskrg = $stocknya['stock'];

    $qtyskrgQuery = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrgQuery);

    if ($qtynya) {
        $qtyskrg = $qtynya['qty'];

        if ($qty > $qtyskrg) {
            $selisih = $qty - $qtyskrg;
            $tambahkanstock = $stockskrg + $selisih;
            $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstock' WHERE idbarang='$idb'");
        } else {
            $selisih = $qtyskrg - $qty;
            $kuranginstock = $stockskrg - $selisih;
            $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$kuranginstock' WHERE idbarang='$idb'");
        }

        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");

        if ($updateStock && $updatenya) {
            header('Location: masuk.php');
            exit();
        } else {
            echo 'Gagal memperbarui barang masuk: ' . mysqli_error($conn);
            header('refresh:5; url=masuk.php');
            exit();
        }
    } else {
        echo 'Data qty tidak ditemukan.';
        header('refresh:5; url=masuk.php');
        exit();
    }
}

// menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = (int)$_POST['qty'];
    $idm = $_POST['idmasuk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('Location: masuk.php');
    } else {
        header('Location: masuk.php');
    }
}

// mengubah data keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = isset($_POST['idkeluar']) ? $_POST['idkeluar'] : null;
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;
    $penerima = isset($_POST['penerima']) ? $_POST['penerima'] : '';

    if (empty($idk)) {
        echo 'ID Keluar tidak ditemukan.';
        header('refresh:5; url=keluar.php');
        exit();
    }

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrgQuery = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrgQuery);

    if ($qtynya) {
        $qtyskrg = $qtynya['qty'];

        if ($qty > $qtyskrg) {
            $selisih = $qty - $qtyskrg;
            $kurangistock = $stockskrg - $selisih;
        } else {
            $selisih = $qtyskrg - $qty;
            $kurangistock = $stockskrg + $selisih;
        }

        $updatestock = mysqli_query($conn, "UPDATE stock SET stock='$kurangistock' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");

        if ($updatestock && $updatenya) {
            header('Location: keluar.php');
            exit();
        } else {
            echo 'Gagal memperbarui barang keluar: ' . mysqli_error($conn);
            header('refresh:5; url=keluar.php');
            exit();
        }
    } else {
        echo 'Data qty tidak ditemukan.';
        header('refresh:5; url=keluar.php');
        exit();
    }
}

// menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = (int)$_POST['qty'];
    $idk = $_POST['idkeluar'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('Location: keluar.php');
    } else {
        header('Location: keluar.php');
    }
}
?>

