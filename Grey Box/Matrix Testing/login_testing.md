
# 🧪 Grey Box Testing – Login

## 📄 Source Code (`login.php`)
```php
<?php
include 'koneksi.php';
session_start();

$status = '';
$message = '';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    //cari database
    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password'");
    //hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True';
        header('location:index.php');
    } else {
        header('location:login.php');
    };
};

if(!isset($_SESSION['log'])){

} else {
    header('location:index.php');
}

?>
