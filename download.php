<?php
if (isset($_GET['file'])) {
    $encoded = $_GET['file'];
    $url = base64_decode($encoded);

    // Optional: validate URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        die("Invalid URL.");
    }

    header("Location: $url");
    exit();
} else {
    echo "No file specified.";
}
