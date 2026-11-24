<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protofolio_20246019";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql_about = "SELECT id, judul, deskripsi, sub_deskripsi FROM about_cards";
$result_about = $conn->query($sql_about);

$sql_skills = "SELECT nama_skill, nilai FROM skills_chart";
$result_skills = $conn->query($sql_skills);

$skill_labels = [];
$skill_values = [];

if ($result_skills->num_rows > 0) {
  while($row_skill = $result_skills->fetch_assoc()) {
    $skill_labels[] = $row_skill["nama_skill"];
    $skill_values[] = (int)$row_skill["nilai"];
  }
}
?>

<section class="about-section" id="about">
    <h2 class="about-title">About</h2>

    <div class="about-content">
        <div class="about-text">
            <h1>About Me</h1>

            <div class="about-content">
            <div class="about-text">
                <div class="about-grid">
                    <?php
                    if ($result_about->num_rows > 0) {
                      while($row = $result_about->fetch_assoc()) {
                        echo '<div class="about-card">';
                        echo '  <h3>' . htmlspecialchars($row["judul"]) . '</h3>';
                        echo '  <p>' . htmlspecialchars($row["deskripsi"]) . '</p>';
                        
                        if (!empty($row["sub_deskripsi"])) {
                          echo '  <span>' . htmlspecialchars($row["sub_deskripsi"]) . '</span>';
                        }
                        
                        echo '</div>';
                      }
                    } else {
                      echo "0 results";
                    }
                    ?>
                </div>
            </div>

            <div class="performance">
                <h2>Performance</h2>
                <p class="chart-subtitle">Technology Skills <span id="live-status" style="color: #16a34a; font-size: 0.85em;">● Live</span></p>

                <div class="line-chart chart-container">
                    <canvas id="skillsChart" aria-label="Grafik tingkat kemampuan teknologi" role="img"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('skillsChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($skill_labels); ?>,
            datasets: [{
                label: 'Tingkat Kemampuan (%)',
                data: <?php echo json_encode($skill_values); ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>