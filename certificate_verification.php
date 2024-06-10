<?php
// Database connection
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

// Initialize variables
$certificate_no = $company_name = $company_address = $manufacturing_address = $valid_until = $product = $dc_executive_officer = $auditor = $chief_auditor = $qr_code_url = '';
$error_message = '';

// Check if certificate number is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['certificate_no'])) {
    // Sanitize certificate number input
    $certificate_no = $conn->real_escape_string($_POST['certificate_no']);
    
    // Fetch certificate details from the database based on certificate number
    $sql = "SELECT * FROM certificates WHERE certificate_no = '$certificate_no'";
    $result = $conn->query($sql);

    // Check if certificate details exist
    if ($result && $result->num_rows > 0) {
        // Fetch data from the database
        $row = $result->fetch_assoc();
        $company_name = $row['Company_Name'];
        $company_address = $row['Company_Address'];
        $manufacturing_address = $row['Manufacturing_Address'];
        $valid_until = $row['Valid_Until'];
        $product = $row['Product'];
        $dc_executive_officer = $row['DC_Executive_Officer'];
        $auditor = $row['Auditor'];
        $chief_auditor = $row['Chief_Auditor'];
        $qr_code_url = $row['qr_code_url'];
    } else {
        $error_message = "Certificate not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h3 {
            margin-top: 20px;
        }

        p {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Certificate Verification</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="certificate_no">Enter Certificate Number:</label><br>
            <input type="text" id="certificate_no" name="certificate_no" value="<?php echo htmlspecialchars($certificate_no); ?>"><br><br>
            <input type="submit" value="Verify">
        </form>

        <?php if ($error_message): ?>
            <p><?php echo $error_message; ?></p>
        <?php elseif ($certificate_no && $company_name): ?>
            <h3>Certificate Details</h3>
            <p><strong>Certificate Number:</strong> <?php echo $certificate_no; ?></p>
            <p><strong>Company Name:</strong> <?php echo $company_name; ?></p>
            <p><strong>Company Address:</strong> <?php echo $company_address; ?></p>
            <p><strong>Manufacturing Address:</strong> <?php echo $manufacturing_address; ?></p>
            <p><strong>Valid Until:</strong> <?php echo $valid_until; ?></p>
            <p><strong>Product:</strong> <?php echo $product; ?></p>
            <p><strong>DC Executive Officer:</strong> <?php echo $dc_executive_officer; ?></p>
            <p><strong>Auditor:</strong> <?php echo $auditor; ?></p>
            <p><strong>Chief Auditor:</strong> <?php echo $chief_auditor; ?></p>
            <p><strong>QR Code:</strong><br><a href="https://intellectworks.co.uk/halal_certificate/certificate_verification.php?certificate_no=<?php echo $certificate_no; ?>"><img src="<?php echo $qr_code_url; ?>" alt="QR Code"></a></p>
        <?php endif; ?>
    </div>
</body>
</html>
