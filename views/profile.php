<?php

require_once "../controllers/ProfileController.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h4 class="mb-0">
                        Student Profile
                    </h4>

                </div>

                <div class="card-body">

                    <!-- SUCCESS MESSAGE -->
                    <?php if (isset($_SESSION['upload_success'])): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['upload_success']) ?>
                        </div>

                        <?php unset($_SESSION['upload_success']); ?>

                    <?php endif; ?>


                    <!-- ERROR MESSAGE -->
                    <?php if (isset($_SESSION['upload_error'])): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['upload_error']) ?>
                        </div>

                        <?php unset($_SESSION['upload_error']); ?>

                    <?php endif; ?>


                    <!-- PROFILE PICTURE -->

                    <div class="text-center mb-4">

                        <?php if (!empty($user['profile_picture'])): ?>

                            <img src="../uploads/profile/<?= htmlspecialchars($user['profile_picture']) ?>"
                                 alt="Profile Picture"
                                 class="rounded-circle"
                                 width="150"
                                 height="150"
                                 style="object-fit: cover;">

                        <?php else: ?>

                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                 style="width:150px; height:150px;">

                                No Photo

                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- UPLOAD PROFILE PICTURE -->

                    <form action="../controllers/ProfileController.php"
                          method="POST"
                          enctype="multipart/form-data"
                          class="mb-4">

                        <label class="form-label">
                            Profile Picture
                        </label>

                        <input type="file"
                               name="profile_picture"
                               class="form-control"
                               accept=".jpg,.jpeg,.png"
                               required>

                        <div class="form-text">
                            JPG, JPEG or PNG only. Maximum size: 2MB.
                        </div>

                        <button type="submit"
                                class="btn btn-primary mt-3">

                            Upload Picture

                        </button>

                    </form>


                    <hr>


                    <!-- STUDENT INFORMATION -->

                    <div class="mb-3">

                        <strong>Name:</strong>

                        <?= htmlspecialchars($user['name']) ?>

                    </div>


                    <div class="mb-3">

                        <strong>NRIC:</strong>

                        <?= htmlspecialchars($user['nric']) ?>

                    </div>


                    <div class="mb-3">

                        <strong>Program:</strong>

                        <?= htmlspecialchars($user['program']) ?>

                    </div>


                    <hr>


                    <!-- GRADE MANAGEMENT -->

                    <a href="students.php"
                       class="btn btn-primary">

                        Grade Management

                    </a>


                    <!-- CHANGE PASSWORD -->

                    <a href="change_password.php"
                       class="btn btn-warning">

                        Change Password

                    </a>


                    <!-- LOGOUT -->

                    <a href="../logout.php"
                       class="btn btn-danger">

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>