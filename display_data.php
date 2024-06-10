<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entered Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Entered Data</h2>
    <table>
        <tr>
            <th>Certificate No</th>
            <th>Company Name</th>
            <th>Company Address</th>
            <th>Manufacturing Address</th>
            <th>Valid Until</th>
            <th>Product</th>
            <th>DC Executive Officer</th>
            <th>Auditor</th>
            <th>Chief Auditor</th>
            <th>Edit</th>
        </tr>
        <?php
        // Connect to MySQL
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

        // Fetch data from the database
        $sql = "SELECT * FROM certificates";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['certificate_no']}</td>
                        <td>{$row['Company_Name']}</td>
                        <td>{$row['Company_Address']}</td>
                        <td>{$row['Manufacturing_Address']}</td>
                        <td>{$row['Valid_Until']}</td>
                        <td>{$row['Product']}</td>
                        <td>" . (isset($row['DC_Executive_Officer']) ? $row['DC_Executive_Officer'] : '') . "</td>
                        <td>{$row['Auditor']}</td>
                        <td>{$row['Chief_Auditor']}</td>
                        <td><a href='edit_certificate.php?id={$row['certificate_no']}'>Edit</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No results found</td></tr>";
        }

        // Close the connection
        $conn->close();
        ?>
    </table>
</body>
</html>
