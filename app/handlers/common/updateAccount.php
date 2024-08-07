<?php
session_start();

include('../../core/database.php');


// Function to sanitize input to prevent SQL injection
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Check if form is submitted for username update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    // Get new username from form
    $newUsername = sanitizeInput($_POST['username']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update username in the database
    $updateUsernameQuery = "UPDATE user SET username = '$newUsername' WHERE user_ID = $loggedInUserID";

    if ($conn->query($updateUsernameQuery) === TRUE) {

        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }

    } else {
        echo "Error updating username: " . $conn->error;
    }
}

if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "../../uploads/tenant/";
    $fileName = basename($_FILES["profilePic"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array(strtolower($fileType), $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
            // Update file path in database
            $updatePicQuery = "UPDATE user SET picDirectory = '$targetFilePath' WHERE user_ID = $loggedInUserID";
            if ($conn->query($updatePicQuery) === TRUE) {
                $_SESSION['picDirectory'] = $targetFilePath; // Update session variable
            } else {
                echo "Error updating profile picture: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
    }
}

// Check if form is submitted for phone number update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['phoneNumber'])) {
    // Get new phone number from form
    $newPhoneNumber = sanitizeInput($_POST['phoneNumber']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update phone number in the database
    $updatePhoneNumberQuery = "UPDATE tenant SET phoneNumber = '$newPhoneNumber' WHERE tenant_ID IN (SELECT tenant_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updatePhoneNumberQuery) === TRUE) {
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }
    } else {
        echo "Error updating phone number: " . $conn->error;
    }
}

// Check if form is submitted for email update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emailAddress'])) {
    // Get email address from form
    $newEmail = sanitizeInput($_POST['emailAddress']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update email in the database
    $updateEmailAddressQuery = "UPDATE tenant SET emailAddress = '$newEmail' WHERE tenant_ID IN (SELECT tenant_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updateEmailAddressQuery) === TRUE) {
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }
    } else {
        echo "Error updating phone number: " . $conn->error;
    }
}


$conn->close();
?>
