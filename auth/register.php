<?php

require_once
    __DIR__ .
    "/../config/config.php";

$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama =
        trim($_POST['nama']);

    $email =
        trim($_POST['email']);

    $password =
        $_POST['password'];


    if (
        strlen($password) < 6
    ) {

        $error =
            "Password minimal 6 karakter.";

    } else {

        $hash =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );


        $stmt = $conn->prepare(
            "INSERT INTO users
            (nama,email,password,role)
            VALUES (?,?,?,'user')"
        );


        $stmt->bind_param(
            "sss",
            $nama,
            $email,
            $hash
        );


        if ($stmt->execute()) {

            redirect(
                "/auth/login.php"
            );

        } else {

            $error =
                "Email sudah digunakan.";
        }
    }

}


$pageTitle = "Daftar";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow p-4">

                <h2>
                    Daftar Akun
                </h2>


                <?php if ($error): ?>

                    <div class="alert alert-danger">
                        <?= clean($error) ?>
                    </div>

                <?php endif; ?>


                <form method="POST">

                    <div class="mb-3">

                        <label>Nama</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>


                    <button
                        class="btn btn-primary w-100"
                    >
                        Daftar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>