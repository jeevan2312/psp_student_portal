<?php

class User
{
    private $conn;

    // Database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // Find user by NRIC for login
    public function findByNRIC($nric)
    {
        $sql = "SELECT * FROM users WHERE nric = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nric);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // Find logged-in user by ID
    public function findById($id)
    {
        $sql = "SELECT id, name, nric, program, profile_picture
                FROM users
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // Find user including password for password verification
    public function findByIdWithPassword($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // Update user's password
    public function updatePassword($id, $hashedPassword)
    {
        $sql = "UPDATE users
                SET password = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $id);

        return $stmt->execute();
    }


    // Update user's profile picture
    public function updateProfilePicture($id, $fileName)
    {
        $sql = "UPDATE users
                SET profile_picture = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $fileName, $id);

        return $stmt->execute();
    }
}

?>