<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // MySQL connection parameters
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "halal_certificate";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $certificate_no = $_POST['certificate_no'];
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $manufacturing_address = $_POST['manufacturing_address'];
    $valid_until = $_POST['valid_until'];
    $products = implode(", ", $_POST['products']);
    $dc_executive_officer = $_POST['dc_executive_officer'];
    $auditor = $_POST['auditor'];
    $chief_auditor = $_POST['chief_auditor'];

    // Update data in the database
    $sql = "UPDATE certificates SET 
                Company_Name='$company_name',
                Company_Address='$company_address',
                Manufacturing_Address='$manufacturing_address',
                Valid_Until='$valid_until',
                Product='$products',
                DC_Executive_Officer='$dc_executive_officer',
                Auditor='$auditor',
                Chief_Auditor='$chief_auditor'
            WHERE certificate_no='$certificate_no'";

    if ($conn->query($sql) === TRUE) {
        header("Location: display_data.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    die("Invalid request.");
}
?>
