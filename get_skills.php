<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protofolio_20246019";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nama_skill, nilai FROM skills_chart ORDER BY id ASC";
$result = $conn->query($sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row["nama_skill"];
        $values[] = (int)$row["nilai"];
    }
}

$conn->close();

// Kirim data dalam format JSON
echo json_encode([
    "labels" => $labels,
    "values" => $values
]);
?>