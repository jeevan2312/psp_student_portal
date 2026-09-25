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

// READ all students from database
$students = $studentModel->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Grade Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Grade Management System
                </h4>

                <a href="add_student.php"
                   class="btn btn-light">
                    + Add Student
                </a>

            </div>

        </div>


        <div class="card-body">

            <!-- SUCCESS MESSAGE -->

            <?php if (isset($_SESSION['success'])): ?>

                <div class="alert alert-success">

                    <?= htmlspecialchars($_SESSION['success']) ?>

                </div>

                <?php unset($_SESSION['success']); ?>

            <?php endif; ?>


            <!-- ERROR MESSAGE -->

            <?php if (isset($_SESSION['error'])): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($_SESSION['error']) ?>

                </div>

                <?php unset($_SESSION['error']); ?>

            <?php endif; ?>


            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>IC</th>
                            <th>Marks</th>
                            <th width="220">Action</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($students->num_rows > 0): ?>

                        <?php while ($student = $students->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= (int)$student['id'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student['name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student['ic']) ?>
                                </td>

                                <td>
                                    <?= (int)$student['marks'] ?>
                                </td>


                                <td>

                                    <!-- EDIT -->

                                    <a href="edit_student.php?id=<?= (int)$student['id'] ?>"
                                       class="btn btn-warning btn-sm">

                                        Edit

                                    </a>


                                    <!-- DELETE -->

                                    <form action="../controllers/StudentController.php"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this student?');">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= (int)$student['id'] ?>">

                                        <button type="submit"
                                                name="delete_student"
                                                class="btn btn-danger btn-sm">

                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endwhile; ?>


                    <?php else: ?>

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                No student records found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <a href="profile.php"
               class="btn btn-secondary">

                Back to Profile

            </a>

        </div>

    </div>

</div>

</body>
</html>