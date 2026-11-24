<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enjoy on my Website</title>
    <link rel="stylesheet" href="asset/css/style.css">

    <!-- Tambahan CSS untuk Autoscroll, Menu Active, dan Container ChartJS -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        .navbar .menu a {
            transition: color 0.3s ease, border-bottom 0.3s ease;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
        }

        /* Styling item menu yang sedang aktif */
        .navbar .menu a.active {
            color: #0d6efd;
            font-weight: 700;
            border-bottom: 2px solid #0d6efd;
        }

        /* Container responsif untuk Chart.js */
        .chart-container {
            position: relative;
            width: 100%;
            height: 260px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="asset/img/D Logo.png" alt="Logo D">
    </div>

    <div class="menu">
        <a href="#home" class="active">Home</a>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </div>
</div>

<div class="home" id="home">
    <div class="home-content">
        <h1>Hallo! Saya David Rido Patria</h1>
        <p>Saya membuat web ini untuk latihan menggunakan Bootstrap</p>
    </div>
    <div class="home-image">
        <img src="asset/img/fotosaya.png" class="foto" alt="Foto David Rido Patria">
    </div>
</div>

<?php
include 'services.php';
?>

<?php
include 'about.php';
?>

<?php
include 'contact.php';
?>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-about">
            <h2>David Rido Patria</h2>
            <p>
                Engineering & Technology Enthusiast.
                Tertarik pada teknologi, desain, dan pengembangan sistem.
            </p>
        </div>

        <div class="footer-links">
            <h3>Navigasi</h3>
            <a href="#home">Home</a>
            <a href="#services">Services</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="footer-contact">
            <h3>Hubungi Saya</h3>
            <p>Email: david.20246019@student.atmi.ac.id</p>
            <p>Lokasi: Surakarta, Indonesia</p>
            <div class="footer-social">
                <a href="https://www.linkedin.com/">LinkedIn</a>
                <a href="https://github.com/">GitHub</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 David Rido Patria. All Rights Reserved.</p>
    </div>
</footer>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.querySelector('.navbar');
        const menuLinks = document.querySelectorAll('.navbar .menu a');
        const allSectionLinks = document.querySelectorAll('a[href^="#"]');
        const sections = document.querySelectorAll('#home, #services, #about, #contact');

        // Fungsi untuk memperbarui status menu active
        function setActiveMenu(targetId) {
            menuLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${targetId}`) {
                    link.classList.add('active');
                }
            });
        }

        // 1 & 2. Event klik untuk menu active & smooth autoscroll ke section tujuan
        allSectionLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const targetHref = this.getAttribute('href');
                if (targetHref && targetHref.length > 1) {
                    const targetSection = document.querySelector(targetHref);
                    if (targetSection) {
                        e.preventDefault();

                        // Hitung offset jika navbar bersifat fixed atau sticky
                        const navPosition = navbar ? getComputedStyle(navbar).position : '';
                        const navOffset = (navPosition === 'fixed' || navPosition === 'sticky')
                            ? navbar.offsetHeight
                            : 0;

                        const targetPosition = targetSection.getBoundingClientRect().top + window.scrollY - navOffset;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                        // Langsung tandai menu yang diklik sebagai active
                        setActiveMenu(targetSection.id);
                    }
                }
            });
        });

        // Sinkronisasi otomatis menu active saat pengguna melakukan scroll halaman
        window.addEventListener('scroll', () => {
            const navPosition = navbar ? getComputedStyle(navbar).position : '';
            const navOffset = (navPosition === 'fixed' || navPosition === 'sticky')
                ? navbar.offsetHeight
                : 0;

            let currentSectionId = 'home';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - navOffset - 100;
                if (window.scrollY >= sectionTop) {
                    currentSectionId = section.id;
                }
            });

            // Jika sudah mencapai bagian paling bawah halaman, aktifkan menu Contact
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 10) {
                currentSectionId = 'contact';
            }

            setActiveMenu(currentSectionId);
        });

        // 3. Inisialisasi Grafik Technology Skills dengan Chart.js
        const chartCanvas = document.getElementById('skillsChart');
        if (chartCanvas) {
            const ctx = chartCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Electrical', 'PLC', 'Microcontroller', 'Mechanical', 'Embedded'],
                    datasets: [{
                        label: 'Tingkat Kemampuan (%)',
                        data: [75, 85, 65, 90, 80],
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 25
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.08)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ` Kemampuan: ${context.parsed.y}%`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

</body>
</html>