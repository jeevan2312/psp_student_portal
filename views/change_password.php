<?php

session_start();

// Only logged-in students can access this page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-warning">
                    <h4 class="mb-0">Change Password</h4>
                </div>

                <div class="card-body p-4">

                    <?php if (isset($_SESSION['error'])): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </div>

                        <?php unset($_SESSION['error']); ?>

                    <?php endif; ?>


                    <?php if (isset($_SESSION['success'])): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </div>

                        <?php unset($_SESSION['success']); ?>

                    <?php endif; ?>


                    <form action="../controllers/AuthController.php"
                          method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Old Password
                            </label>

                            <input type="password"
                                   name="old_password"
                                   class="form-control"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input type="password"
                                   name="new_password"
                                   class="form-control"
                                   minlength="6"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input type="password"
                                   name="confirm_password"
                                   class="form-control"
                                   minlength="6"
                                   required>

                        </div>


                        <button type="submit"
                                name="change_password"
                                class="btn btn-warning w-100">

                            Update Password

                        </button>

                    </form>


                    <a href="profile.php"
                       class="btn btn-secondary w-100 mt-3">

                        Back to Profile

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>