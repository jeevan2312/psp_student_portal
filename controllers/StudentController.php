<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "../config/database.php";
require_once "../models/student.php";

// Only logged-in users can access CRUD functions
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$studentModel = new Student($conn);


/* =========================================
   CREATE STUDENT
   ========================================= */

if (isset($_POST['create_student'])) {

    $name = trim($_POST['name'] ?? '');
    $ic = trim($_POST['ic'] ?? '');
    $marks = trim($_POST['marks'] ?? '');

    // Server-side validation
    if ($name === '' || $ic === '' || $marks === '') {

        $_SESSION['error'] = "Please fill in all fields.";

        header("Location: ../views/add_student.php");
        exit();
    }

    // Validate marks
    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $_SESSION['error'] =
            "Marks must be between 0 and 100.";

        header("Location: ../views/add_student.php");
        exit();
    }

    if ($studentModel->create($name, $ic, (int)$marks)) {

        $_SESSION['success'] =
            "Student added successfully.";

        header("Location: ../views/students.php");
        exit();

    } else {

        $_SESSION['error'] =
            "Failed to add student.";

        header("Location: ../views/add_student.php");
        exit();
    }
}


/* =========================================
   UPDATE STUDENT
   ========================================= */

elseif (isset($_POST['update_student'])) {

    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $ic = trim($_POST['ic'] ?? '');
    $marks = trim($_POST['marks'] ?? '');

    // Server-side validation
    if ($id <= 0 || $name === '' || $ic === '' || $marks === '') {

        $_SESSION['error'] =
            "Please provide valid student information.";

        header("Location: ../views/students.php");
        exit();
    }

    // Validate marks
    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $_SESSION['error'] =
            "Marks must be between 0 and 100.";

        header(
            "Location: ../views/edit_student.php?id=" . $id
        );
        exit();
    }

    if (
        $studentModel->update(
            $id,
            $name,
            $ic,
            (int)$marks
        )
    ) {

        $_SESSION['success'] =
            "Student updated successfully.";

        header("Location: ../views/students.php");
        exit();

    } else {

        $_SESSION['error'] =
            "Failed to update student.";

        header(
            "Location: ../views/edit_student.php?id=" . $id
        );
        exit();
    }
}


/* =========================================
   DELETE STUDENT
   ========================================= */

elseif (isset($_POST['delete_student'])) {

    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {

        $_SESSION['error'] =
            "Invalid student ID.";

        header("Location: ../views/students.php");
        exit();
    }

    if ($studentModel->delete($id)) {

        $_SESSION['success'] =
            "Student deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to delete student.";
    }

    header("Location: ../views/students.php");
    exit();
}


/* =========================================
   DIRECT ACCESS
   ========================================= */

else {

    header("Location: ../views/students.php");
    exit();
}

?>