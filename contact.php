<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protofolio_20246019";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$status_pesan = "";

// 1. Proses simpan pesan jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["kirim_pesan"])) {
  $nama   = $_POST["name"];
  $email  = $_POST["email"];
  $subjek = $_POST["subject"];
  $pesan  = $_POST["message"];

  // Menggunakan prepared statement agar aman dari SQL Injection
  $stmt = $conn->prepare("INSERT INTO contact_messages (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nama, $email, $subjek, $pesan);

  if ($stmt->execute()) {
    $status_pesan = '<p style="color: #16a34a; font-weight: bold; margin-bottom: 15px;">Pesan berhasil dikirim! Terima kasih telah menghubungi.</p>';
  } else {
    $status_pesan = '<p style="color: #dc2626; font-weight: bold; margin-bottom: 15px;">Gagal mengirim pesan: ' . $stmt->error . '</p>';
  }

  $stmt->close();
}

// 2. Ambil data informasi kontak dari database
$sql_contact = "SELECT id, ikon, judul, isi FROM contact_info";
$result_contact = $conn->query($sql_contact);
?>

<section class="contact-section" id="contact">
    <h2 class="contact-title">Contact</h2>
    <p class="contact-subtitle">
        Mari berdiskusi mengenai teknologi,
        engineering, dan peluang kolaborasi.
    </p>

    <div class="contact-content">
        <div class="contact-info">
            <h3>Hubungi Saya</h3>
            <p>
                Tertarik berdiskusi atau bekerja sama?
                Silakan hubungi saya melalui informasi berikut.
            </p>

            <?php
            if ($result_contact->num_rows > 0) {
              while($row = $result_contact->fetch_assoc()) {
                echo '<div class="contact-item">';
                echo '  <div class="contact-icon">' . htmlspecialchars($row["ikon"]) . '</div>';
                echo '  <div>';
                echo '    <h4>' . htmlspecialchars($row["judul"]) . '</h4>';
                echo '    <p>' . htmlspecialchars($row["isi"]) . '</p>';
                echo '  </div>';
                echo '</div>';
              }
            } else {
              echo "0 results";
            }
            ?>
        </div>

        <div class="contact-form">
            <h3>Kirim Pesan</h3>

            <!-- Menampilkan notifikasi berhasil/gagal -->
            <?php echo $status_pesan; ?>

            <form action="#contact" method="post">
                <label for="contact-name">Nama</label>
                <input
                    type="text"
                    id="contact-name"
                    name="name"
                    placeholder="Masukkan nama kamu"
                    required
                >

                <label for="contact-email">Email</label>
                <input
                    type="email"
                    id="contact-email"
                    name="email"
                    placeholder="Example@gmail.com"
                    required
                >

                <label for="contact-subject">Subjek</label>
                <input
                    type="text"
                    id="contact-subject"
                    name="subject"
                    placeholder="Topik pesan"
                    required
                >

                <label for="contact-message">Pesan</label>
                <textarea
                    id="contact-message"
                    name="message"
                    rows="5"
                    placeholder="Tulis pesan kamu..."
                    required
                ></textarea>

                <button type="submit" name="kirim_pesan">Kirim Pesan</button>
            </form>
        </div>
    </div>
</section>

<?php
$conn->close();
?>



<!-- <section class="contact-section" id="contact">
    <h2 class="contact-title">Contact</h2>
    <p class="contact-subtitle">
        Mari berdiskusi mengenai teknologi,
        engineering, dan peluang kolaborasi.
    </p>

    <div class="contact-content">
        <div class="contact-info">
            <h3>Hubungi Saya</h3>
            <p>
                Tertarik berdiskusi atau bekerja sama?
                Silakan hubungi saya melalui informasi berikut.
            </p>

            <div class="contact-item">
                <div class="contact-icon">✉</div>
                <div>
                    <h4>Email</h4>
                    <p>david.20246019@student.atmi.ac.id</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">☎</div>
                <div>
                    <h4>Telepon</h4>
                    <p>+62 88215747663</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">⌖</div>
                <div>
                    <h4>Lokasi</h4>
                    <p>Surakarta, Indonesia</p>
                </div>
            </div>
        </div>

        <div class="contact-form">
            <h3>Kirim Pesan</h3>

            <form action="#" method="post">
                <label for="contact-name">Nama</label>
                <input
                    type="text"
                    id="contact-name"
                    name="name"
                    placeholder="Masukkan nama kamu"
                    required
                >

                <label for="contact-email">Email</label>
                <input
                    type="email"
                    id="contact-email"
                    name="email"
                    placeholder="Example@gmail.com"
                    required
                >

                <label for="contact-subject">Subjek</label>
                <input
                    type="text"
                    id="contact-subject"
                    name="subject"
                    placeholder="Topik pesan"
                    required
                >

                <label for="contact-message">Pesan</label>
                <textarea
                    id="contact-message"
                    name="message"
                    rows="5"
                    placeholder="Tulis pesan kamu..."
                    required
                ></textarea>

                <button type="submit">Kirim Pesan</button>
            </form>
        </div>
    </div>
</section> -->