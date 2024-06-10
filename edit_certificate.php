<?php
// Check if ID is set
if (!isset($_GET['id'])) {
    die("Certificate ID not specified.");
}

$certificate_no = $_GET['id'];

// Connect to MySQL
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "halal_certificate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM certificates WHERE certificate_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certificate_no);
$stmt->execute();
$result = $stmt->get_result();
$certificate = $result->fetch_assoc();

if (!$certificate) {
    die("Certificate not found.");
}
// Check if certificate ID is provided in the URL
if (isset($_GET['id'])) {
    $certificate_id = $_GET['id'];

    // Fetch certificate data from the database
    $sql = "SELECT * FROM certificates WHERE certificate_no = $certificate_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row (assuming certificate ID is unique)
        $certificate = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .product-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .product-input input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }
        .add-button {
            display: block;
            margin-top: 10px;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Certificate</h2>
        <form action="update_certificate.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="certificate_no" value="<?php echo $certificate['certificate_no']; ?>">
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" value="<?php echo $certificate['Company_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="company_address">Company Address:</label>
                <input type="text" id="company_address" name="company_address" value="<?php echo $certificate['Company_Address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="manufacturing_address">Manufacturing Address:</label>
                <input type="text" id="manufacturing_address" name="manufacturing_address" value="<?php echo $certificate['Manufacturing_Address']; ?>" required>
            </div>
            <div class="form-group">
            <label for="valid_until">Valid Until:</label>
        <input type="date" id="valid_until" name="valid_until" value="<?php echo $certificate['Valid_Until']; ?>" required><br>

            </div>
            <div class="form-group">
            <label for="product">Products:</label><br>
            <div id="product-container">
                <?php
                $products = explode(", ", $certificate['Product']);
                foreach ($products as $product) {
                    echo "<div class='product-input'>
                            <input type='text' name='products[]' value='$product' required>
                            <button type='button' onclick='removeProductField(this)'>Remove</button>
                          </div>";
                }
                ?>
            </div>
            <span class="add-button" onclick="addProductField()">+ Add another product</span><br><br>
            <div class="form-group">
            <label for="dc_executive_officer">DC Executive Officer:</label>
<input type="text" id="dc_executive_officer" name="dc_executive_officer" value="<?php echo isset($certificate['DC_Executive_Officer']) ? $certificate['DC_Executive_Officer'] : ''; ?>" required>

            </div>
            <div class="form-group">
                <label for="auditor">Auditor:</label>
                <input type="text" id="auditor" name="auditor" value="<?php echo $certificate['Auditor']; ?>" required>
            </div>
            <div class="form-group">
                <label for="chief_auditor">Chief Auditor:</label>
                <input type="text" id="chief_auditor" name="chief_auditor" value="<?php echo $certificate['Chief_Auditor']; ?>" required>
            </div>
            <input type="submit" value="Update">
        </form>
    </div>

    <script>
        function validateForm() {
            var requiredFields = [
                "company_name",
                "company_address",
                "manufacturing_address",
                "valid_until",
                "dc_executive_officer",
                "auditor",
                "chief_auditor"
            ];

            for (var i = 0; i < requiredFields.length; i++) {
                var field = document.getElementById(requiredFields[i]);
                if (field.value.trim() === "") {
                    alert(field.previousElementSibling.textContent + " is required");
                    return false;
                }
            }

            var productInputs = document.getElementsByName("products[]");
            for (var i = 0; i < productInputs.length; i++) {
                if (productInputs[i].value.trim() === "") {
                    alert("All product fields must be filled out");
                    return false;
                }
            }

            return true;
        }
        function validateForm() {
            var validUntil = new Date(document.getElementById("valid_until").value);
            var today = new Date();

            if (validUntil < today) {
                alert("Valid Until date must be a future date.");
                return false;
            }

            return true;
        }
        function addProductField() {
            var container = document.getElementById("product-container");
            var newProductField = document.createElement("div");
            newProductField.className = "product-input";
            newProductField.innerHTML = `
                <input type="text" name="products[]" required>
                <button type="button" onclick="removeProductField(this)">Remove</button>
            `;
            container.appendChild(newProductField);
        }

        function removeProductField(button) {
            var container = document.getElementById("product-container");
            container.removeChild(button.parentElement);
        }
    </script>
</body>
</html>
<?php
    } else {
        echo "Certificate not found.";
    }
} else {
    echo "Certificate ID is missing.";
}
?>
