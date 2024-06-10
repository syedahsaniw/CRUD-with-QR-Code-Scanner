<?php
require 'phpqrcode/qrlib.php';  // Include the PHP QR Code library

// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "halal_certificate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$certificate_no = $_POST['certificate_no'];
$company_name = $_POST['company_name'];
$company_address = $_POST['company_address'];
$manufacturing_address = $_POST['manufacturing_address'];
$valid_until = $_POST['valid_until'];
$product = $_POST['product'];
$dc_executive_officer = $_POST['dc_executive_officer'];
$auditor = $_POST['auditor'];
$chief_auditor = $_POST['chief_auditor'];

// Generate a unique ID
$unique_id = uniqid();

// QR code content
$qr_content = "Certificate No: $certificate_no\nCompany Name: $company_name\nCompany Address: $company_address\nManufacturing Address: $manufacturing_address\nValid Until: $valid_until\nProduct: $product\nDC Executive Officer: $dc_executive_officer\nAuditor: $auditor\nChief Auditor: $chief_auditor\nUnique ID: $unique_id";

// Generate QR code and save as image
$qr_filename = 'qrcodes/' . $unique_id . '.png';
QRcode::png($qr_content, $qr_filename);

// Insert data into the database
$stmt = $conn->prepare("INSERT INTO certificates (certificate_no, company_name, company_address, manufacturing_address, valid_until, product, dc_executive_officer, auditor, chief_auditor, qr_code_url, unique_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $certificate_no, $company_name, $company_address, $manufacturing_address, $valid_until, $product, $dc_executive_officer, $auditor, $chief_auditor, $qr_filename, $unique_id);

if ($stmt->execute()) {
    echo "Record inserted successfully with QR code!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
