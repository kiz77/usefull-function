<?php

$servername = "localhost";
$username = "csv";
$password = ""; // Change this if necessary
$database = "csv"; // Change to your actual database
$csv_file = "channels.csv"; // Path to CSV file
$x=1;
// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open the CSV file
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    $header = fgetcsv($handle); // Read the first row as column names
    
    // Generate CREATE TABLE statement
    $table_name = "allchannels";
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (";
    foreach ($header as $col) {
        $sql .= "`$col` VARCHAR(255), "; // Default to VARCHAR(255)
    }
    $sql = rtrim($sql, ", ") . ");"; // Remove trailing comma and close statement

    // Execute table creation
    if (!$conn->query($sql)) {
        die("Error creating table: " . $conn->error);
    }

    // Prepare INSERT statement
    $placeholders = implode(", ", array_fill(0, count($header), "?"));
    $insert_sql = "INSERT INTO `$table_name` (`" . implode("`, `", $header) . "`) VALUES ($placeholders)";
    $stmt = $conn->prepare($insert_sql);

    // Bind values dynamically
    while (($row = fgetcsv($handle)) !== FALSE) {
        $stmt->bind_param(str_repeat("s", count($row)), ...$row);
        $sam=$stmt->execute();
		echo 'No:'.$x.': ';
		print_r($sam);
		echo "\n";
		$x++;
    }

    fclose($handle);
    echo "CSV imported successfully!";
} else {
    echo "Failed to open file.";
}

$conn->close();
?>
