<?php

require_once
    __DIR__ .
    "/../config/config.php";

$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email =
        trim($_POST['email']);

    $password =
        $_POST['password'];


    $stmt = $conn->prepare(
        "SELECT *
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $stmt->bind_param(
        "s",
        $email
    );

    $stmt->execute();

    $result =
        $stmt->get_result();

    $user =
        $result->fetch_assoc();


    if (
        $user &&
        password_verify(
            $password,
            $user['password']
        )
    ) {

        $_SESSION['user'] = [

            'id_user' =>
                $user['id_user'],

            'nama' =>
                $user['nama'],

            'email' =>
                $user['email'],

            'role' =>
                $user['role']
        ];


        if (
            $user['role'] === 'admin'
        ) {

            redirect(
                "/admin/dashboard.php"
            );

        } else {

            redirect(
                "/user/home.php"
            );
        }

    } else {

        $error =
            "Email atau password salah.";
    }

}


$pageTitle = "Login";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="mb-4">
                    Login
                </h2>


                <?php if ($error): ?>

                    <div class="alert alert-danger">
                        <?= clean($error) ?>
                    </div>

                <?php endif; ?>


                <form method="POST">

                    <div class="mb-3">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Password
                        </label>

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
                        Login
                    </button>

                </form>


                <p class="mt-3 text-center">

                    Belum punya akun?

                    <a
                        href="<?= BASE_URL ?>/auth/register.php"
                    >
                        Daftar
                    </a>

                </p>

            </div>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>