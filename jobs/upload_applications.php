<?php
// Include database connection
require 'database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $full_name = htmlspecialchars(trim($_POST["full_name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $cover = htmlspecialchars(trim($_POST["cover"]));
    $job_id = intval($_POST["job_id"]);  // Capture job ID from the form
    $job_title = htmlspecialchars(trim($_POST['job_title']));  // Sanitize job title

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "applications/";  // Directory to store resumes
        $file_name = time() . "_" . basename($_FILES['resume']['name']);
        $file_path = $upload_dir . $file_name;

        // Validate file type (PDF, DOC, DOCX)
        $allowed_types = ['pdf', 'doc', 'docx'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_ext), $allowed_types)) {
            echo "Invalid file type. Only PDF and Word documents are allowed.";
            exit;
        }

        // Validate file size (optional, here set to 10MB max)
        $max_size = 10 * 1024 * 1024; // 10MB in bytes
        if ($_FILES['resume']['size'] > $max_size) {
            echo "File is too large. Maximum file size is 10MB.";
            exit;
        }

        // Save the file to the uploads folder
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $file_path)) {
            try {
                // Prepare SQL query to insert user information into the database
                $stmt = $conn->prepare("INSERT INTO applications (job_id, job_title, full_name, phone, email, cover, resume_path)
                                        VALUES (:job_id, :job_title, :full_name, :phone, :email, :cover, :resume_path)");

                // Bind parameters
                $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
                $stmt->bindParam(':job_title', $job_title, PDO::PARAM_STR);
                $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':cover', $cover, PDO::PARAM_STR);
                $stmt->bindParam(':resume_path', $file_path, PDO::PARAM_STR);

                // Execute the statement
                $stmt->execute();

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
