<?php
require 'config.php';

if (isset($_SESSION['access_token'])) {
    $revokeParams = array('token' => $_SESSION['access_token']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tockenRevocationUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($revokeParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

session_destroy();
header("Location: index.php");
exit;
?>
