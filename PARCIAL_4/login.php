<?php
require 'GoogleAuth.php';
$auth = new GoogleAuth($pdo);

if (isset($_GET['code'])) {
    if ($auth->authenticate($_GET['code'])) {
        header('Location: biblioteca.php');
        exit;
    } else {
        echo 'Error retrieving access token.';
    }
} else {
    header('Location: ' . $auth->getAuthUrl());
    exit;
}
?>
