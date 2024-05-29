<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';
?>

<body>

    <?php
    include 'includes/navbar.php';
    ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Welcome to MosqueMIS</h1>
            <p>Manage your mosque activities efficiently and effectively</p>
            <a href="#register" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section" id="features">
        <div class="container">
            <h2>Our Features</h2>
            <div class="row">
                <div class="col-md-4 feature">
                    <i class="fas fa-wallet fa-3x"></i> <!-- Increased icon size -->
                    <h4>Keuangan Masjid</h4>
                    <p>Mengelola keuangan masjid, transaksi pemasukan dan pengeluaran</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-bullhorn fa-3x"></i> <!-- Increased icon size -->
                    <h4>Publikasi Kegiatan Masjid</h4>
                    <p>Menjadi arsip untuk seluruh kegiatan yang diselenggarakan oleh masjid</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-book fa-3x"></i> <!-- Increased icon size -->
                    <h4>Sarana Dakwah & Ilmu</h4>
                    <p>dengan adanya fitur perpustakaan dan Blog dakwah menambah khazanah pengetahuan islami</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Section -->
    <div class="blog-section" id="blog">
        <div class="container">
            <h2>Latest Blog Posts</h2>
            <div class="row">
                <?php
                $sql = "SELECT * FROM blog ORDER BY dibuat_pada DESC LIMIT 3";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-4">';
                        echo '<img src="admin/blog/' . $row["foto"] . '" class="card-img-top" alt="Blog Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row["judul"] . '</h5>';
                        echo '<p class="card-text">' . substr($row["isi"], 0, 100) . '...</p>';
                        echo '<a href="view_blog.php?id=' . $row['id_blog'] . '" class="btn btn-sm btn-outline-secondary">View</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    // Check if there are more than 3 blog posts
                    $sql_count = "SELECT COUNT(*) AS total FROM blog";
                    $result_count = $conn->query($sql_count);
                    $row_count = $result_count->fetch_assoc();
                    $total_posts = $row_count['total'];
                    if ($total_posts > 3) {
                        echo '<div class="col-md-12 text-center mt-3">';
                        echo '<a href="blog.php" class="btn btn-primary">View More</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No blog posts found.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div class="prayer-times-section">
        <div class="container">
            <h2>Prayer Times</h2>
            <div id="prayer-times" class="table-responsive">
                <table class="table prayer-times-table">
                    <thead>
                        <tr>
                            <th>Fajr</th>
                            <th>Dhuhr</th>
                            <th>Asr</th>
                            <th>Maghrib</th>
                            <th>Isha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Prayer times will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .hero-section {
            background: url('image/home/1.jpg') no-repeat center center;
            background-size: cover;
            padding: 150px 0;
            /* Increased padding */
            color: white;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.5rem;
        }

        .prayer-times-section {
            padding: 50px 0;
            background: #f8f9fa;
        }

        .prayer-times-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .prayer-times-table {
            width: 100%;
            border-collapse: collapse;
        }

        .prayer-times-table th,
        .prayer-times-table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .prayer-times-table th {
            background-color: #343a40;
            color: white;
        }

        .prayer-times-table td {
            background-color: #ffffff;
        }

        @media (max-width: 768px) {

            .prayer-times-table th,
            .prayer-times-table td {
                font-size: 0.8rem;
                padding: 8px;
            }
        }
    </style>

    <?php
    include 'includes/footer.php';
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Fetch prayer times
                    const prayerTimesApiUrl = `https://api.aladhan.com/v1/timings?latitude=${latitude}&longitude=${longitude}&method=2`;

                    axios.get(prayerTimesApiUrl)
                        .then(response => {
                            const prayerTimesContainer = document.querySelector('.prayer-times-table tbody');
                            prayerTimesContainer.innerHTML = '';

                            const timings = response.data.data.timings;

                            const row = document.createElement('tr');

                            const fajr = document.createElement('td');
                            fajr.textContent = timings.Fajr;
                            row.appendChild(fajr);

                            const dhuhr = document.createElement('td');
                            dhuhr.textContent = timings.Dhuhr;
                            row.appendChild(dhuhr);

                            const asr = document.createElement('td');
                            asr.textContent = timings.Asr;
                            row.appendChild(asr);

                            const maghrib = document.createElement('td');
                            maghrib.textContent = timings.Maghrib;
                            row.appendChild(maghrib);

                            const isha = document.createElement('td');
                            isha.textContent = timings.Isha;
                            row.appendChild(isha);

                            prayerTimesContainer.appendChild(row);
                        })
                        .catch(error => {
                            console.error('Error fetching prayer times:', error);
                        });

                    // Fetch location details
                    const locationApiUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`;

                    axios.get(locationApiUrl)
                        .then(response => {
                            const location = response.data.address;
                            const locationContainer = document.getElementById('location');
                            locationContainer.innerHTML = `<h4>${location.city}, ${location.state}, ${location.country}</h4>`;
                        })
                        .catch(error => {
                            console.error('Error fetching location details:', error);
                        });

                }, () => {
                    alert('Geolocation is not supported by this browser.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    </script>
</body>

</html>