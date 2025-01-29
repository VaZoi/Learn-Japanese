<?php
require_once('Class/Authentication.php');
$user = $auth->validateUserSession();
$userId = $user['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_email'])) {
        $newEmail = filter_var($_POST['new_email'], FILTER_SANITIZE_EMAIL);
        $result = $auth->updateEmail($userId, $newEmail);
        
        if ($result === true) {
            header("Location: account.php?success=1");
            exit;
        } else {
            header("Location: account.php?error=" . urlencode($result));
            exit;
        }
    }

    if (isset($_POST['update_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $result = $auth->updatePassword($userId, $currentPassword, $newPassword);
        
        if ($result === true) {
            header("Location: account.php?success=1");
            exit;
        } else {
            header("Location: account.php?error=" . urlencode($result));
            exit;
        }
        
    }
}
?>