<?php

class Student
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // CREATE
    public function create($name, $ic, $marks)
    {
        $sql = "INSERT INTO students (name, ic, marks)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $ic, $marks);

        return $stmt->execute();
    }

    // READ ALL
    public function getAll()
    {
        $sql = "SELECT * FROM students ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }

    // READ ONE
    public function getById($id)
    {
        $sql = "SELECT * FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // UPDATE
    public function update($id, $name, $ic, $marks)
    {
        $sql = "UPDATE students
                SET name = ?, ic = ?, marks = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $name, $ic, $marks, $id);

        return $stmt->execute();
    }

    // DELETE
    public function delete($id)
    {
        $sql = "DELETE FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>