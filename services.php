<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protofolio_20246019";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT judul, deskripsi, icon FROM services";
$result = $conn->query($sql);

$conn->close();
?>


<section class="services-section" id="services">
    <h2 class="services-title">Services</h2>

    <div class="services-section" id="services">

        <div class="services">
            <?php
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="icon">' . $row["icon"] . '</div>';
                echo '<h3>' . htmlspecialchars($row["judul"]) . '</h3>';
                echo '<p>' . htmlspecialchars($row["deskripsi"]) . '</p>';
                echo '</div>';
            }
            } else {
            echo "0 results";
            }
            ?>
        </div>
</section>