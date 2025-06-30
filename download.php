<?php
// Path to your directory containing downloadable files
$filesDir = __DIR__ . '/files/'; // Adjust this path as needed

// Get filename from URL parameter
if (!isset($_GET['file'])) {
    die('File not specified.');
}

$file = $_GET['file'];

// Sanitize filename to prevent directory traversal
$file = basename($file); // Remove directory paths

// Complete path
$filePath = $filesDir . $file;

// Check if file exists
if (!file_exists($filePath)) {
    die('File not found.');
}

// Set headers to prompt download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));

// Read the file and output to the browser
readfile($filePath);
exit;
?>
