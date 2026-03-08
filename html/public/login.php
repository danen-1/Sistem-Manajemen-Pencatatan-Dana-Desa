<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f6f9;
        }

        .login-card {
            width: 350px;
        }
    </style>

</head>

<body>

    <div class="card shadow login-card">

        <!-- card body -->
        <div class="card-body">

            <h4 class="text-center mb-4">Login Admin</h4>

            <!-- form login -->
            <form action="../../php/controller/proses_login.php" method="POST">

                <div class="mb-3">

                    <label>Username</label>

                    <input type="text" name="username" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Password</label>

                    <input type="password" name="password" class="form-control" required>

                </div>

                <button class="btn btn-primary w-100">
                    Login
                </button>

            </form>

        </div>

    </div>

</body>

</html>