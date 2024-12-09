<?php
// Include database connection
require 'database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $company = htmlspecialchars(trim($_POST["company"]));

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES['resume']['name']);
        $file_path = $upload_dir . $file_name;

        // Validate file type (PDF, DOC, DOCX)
        $allowed_types = ['pdf', 'doc', 'docx'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_ext), $allowed_types)) {
            echo "Invalid file type. Only PDF and Word documents are allowed.";
            exit;
        }

        // Save the file to the uploads folder
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $file_path)) {
            try {
                // Prepare SQL query to insert user information into the database
                $stmt = $conn->prepare("INSERT INTO job_portal (first_name, phone, email, company, resume_path) 
                                        VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $phone, $email, $company, $file_path]);

                echo "Application submitted successfully!";
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "No file uploaded or there was an error with the file upload.";
    }
} else {
    echo "Invalid request method.";
}
?>
