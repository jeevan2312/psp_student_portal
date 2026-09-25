<?php

session_start();

require_once "../config/database.php";
require_once "../models/student.php";

// Access control
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$studentModel = new Student($conn);

// Get student ID from URL
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: students.php");
    exit();
}

// Get selected student from database
$student = $studentModel->getById($id);

if (!$student) {
    header("Location: students.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-warning">

                    <h4 class="mb-0">
                        Edit Student
                    </h4>

                </div>

                <div class="card-body p-4">


                    <?php if (isset($_SESSION['error'])): ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars($_SESSION['error']) ?>

                        </div>

                        <?php unset($_SESSION['error']); ?>

                    <?php endif; ?>


                    <form action="../controllers/StudentController.php"
                          method="POST">


                        <!-- STUDENT ID -->

                        <input type="hidden"
                               name="id"
                               value="<?= (int)$student['id'] ?>">


                        <!-- NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Student Name
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   maxlength="100"
                                   value="<?= htmlspecialchars($student['name']) ?>"
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
                                   value="<?= htmlspecialchars($student['ic']) ?>"
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
                                   value="<?= (int)$student['marks'] ?>"
                                   required>

                        </div>


                        <button type="submit"
                                name="update_student"
                                class="btn btn-warning w-100">

                            Update Student

                        </button>

                    </form>


                    <a href="students.php"
                       class="btn btn-secondary w-100 mt-3">

                        Cancel

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>