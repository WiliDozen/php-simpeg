<?php


include 'config/core.php';

// cek sessiom jika sudah login
if (isset($_SESSION["login"])){
    header("Location:index.php");
    exit;
}

//jika tombol login ditekan jalankan script dibawah ini:v
if (isset($_POST['login'])){
    $nama   = mysqli_escape_string($db, $_POST['nama']);
    $password   = mysqli_escape_string($db, $_POST['password']);

    //ambil data akun berdsrkan user
    $checkuser  = mysqli_query($db, "SELECT * FROM akun WHERE nama ='$nama'");

    // check validasi akun
    if (mysqli_num_rows($checkuser) === 1){
        //chech password
        $row =mysqli_fetch_assoc($checkuser);
        if (password_verify($password, $row["password"])){
            //set seccsion
            $_SESSION["login"]      = true;
            $_SESSION["id_akun"]    = $row["id_akun"];
            $_SESSION["nama"]       = $row["nama"];
            $_SESSION["role"]       = $row["role"];

            header("location: index.php");
            exit;
        }
    }
    //jika password/username gagal
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="assets/css/styles.css" rel="stylesheet" />
        
        <!-- logo/favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/wd.jpg">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login Simpeg</h3></div>
                                    <div class="card-body">
                                        <?php if (isset($error)) : ?>
                                            <div align="center" class="mb-2 alert alert-danger alert-dismissible fade show" role="alert"><i><b>Username / Password SALAH</b></i>
                                        </div>
                                        <?php endif; ?>
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                                <input class="form-control py-4" name="nama" id="username" type="text" placeholder="Masukan Username Anda........" minlength="4" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input class="form-control py-4" name="password" id="password" type="password" placeholder="Masukan password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="show-password" type="checkbox" />
                                                    <label class="custom-control-label" for="show-password"><small>Lihat password</small>
                                                </label>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button type="submit" name="login" class="btn btn-primary float-right">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="https://api.whatsapp.com/send?phone=082377146731&text=Hai%20Admin%20Saya%20Ingin%20registrasi%20Akun%20:v">Belum punya akun? Klik disini</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; WlyDzn <?= date('Y'); ?></div>
                            <div>
                                <a href="https://facebook.com">Dev By wily dozen</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('#show-password').click(function () {
                if ($(this).is(':checked')) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        });
    </script>
    </body>
</html>
