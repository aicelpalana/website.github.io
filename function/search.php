<?php
session_start();
require 'config.php'; // Include your database configuration file

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    header('Location: ../pages/result.php?query=' . urlencode($search_query));
    exit();
} else {
    header('Location: home.php');
    exit();
}
?>