<?php

session_start();

// Access control
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Add New Student</h4>
                </div>

                <div class="card-body p-4">

                    <!-- ERROR MESSAGE -->

                    <?php if (isset($_SESSION['error'])): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </div>

                        <?php unset($_SESSION['error']); ?>

                    <?php endif; ?>


                    <form action="../controllers/StudentController.php"
                          method="POST">

                        <!-- NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Student Name
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   maxlength="100"
                                   required>

                        </div>


                        <!-- IC -->

                        <div class="mb-3">

                            <label class="form-label">
                                IC Number
                            </label>

                            <input type="text"
                                   name="ic"
                                   class="form-control"
                                   maxlength="20"
                                   required>

                        </div>


                        <!-- MARKS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Marks
                            </label>

                            <input type="number"
                                   name="marks"
                                   class="form-control"
                                   min="0"
                                   max="100"
                                   required>

                        </div>


                        <button type="submit"
                                name="create_student"
                                class="btn btn-success w-100">

                            Add Student

                        </button>

                    </form>


                    <a href="students.php"
                       class="btn btn-secondary w-100 mt-3">

                        Back to Grade Management

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>