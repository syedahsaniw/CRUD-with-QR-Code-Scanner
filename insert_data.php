<?php
// MySQL connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "halal_certificate";
// Include PHP QR Code library
include('phpqrcode/qrlib.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$company_name = $_POST['company_name'];
$company_address = $_POST['company_address'];
$manufacturing_address = $_POST['manufacturing_address'];
$valid_until = $_POST['valid_until'];
$products = implode(", ", $_POST['products']);
$dc_executive_officer = $_POST['dc_executive_officer'];
$auditor = $_POST['auditor'];
$chief_auditor = $_POST['chief_auditor'];

// Generate a unique ID for the submission
$unique_id = uniqid();

// URL that the QR code will link to
$base_url = "http://localhost/display_data.php";
$qr_url = $base_url . "?id=" . $unique_id;

// Path to save the QR code image
$qr_file_path = 'qrcodes/' . $unique_id . '.png';

// Generate QR code image
QRcode::png($qr_url, $qr_file_path, QR_ECLEVEL_L, 10);

// Insert data into the database
$sql = "INSERT INTO certificates (certificate_no, Company_Name, Company_Address, Manufacturing_Address, Valid_Until, Product, DC_Executive_Officer, Auditor, Chief_Auditor, qr_code_url, unique_id)
        VALUES (NULL, '$company_name', '$company_address', '$manufacturing_address', '$valid_until', '$products', '$dc_executive_officer', '$auditor', '$chief_auditor', '$qr_file_path', '$unique_id')";

if ($conn->query($sql) === TRUE) {
    header("Location: display_data.php?id=$unique_id");
    exit;
} else {
    if ($conn->errno == 1062) { // Duplicate entry error
        echo "Certificate already added. <a href='form.php'>Back to form</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
