<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';

$id_pengguna = $_SESSION['id_pengguna'];

// Fetch data from the database
$query = "
    SELECT 
        k.nama_kategori,
        DATE_FORMAT(d.tanggal, '%Y-%m') AS bulan,
        SUM(d.total_dana) AS total_dana
    FROM dana d
    JOIN kategori k ON d.id_kategori = k.id_kategori
    GROUP BY k.nama_kategori, DATE_FORMAT(d.tanggal, '%Y-%m')
    ORDER BY DATE_FORMAT(d.tanggal, '%Y-%m')";

$result = mysqli_query($conn, $query);

$data = [];
$categories = [];
$months = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['nama_kategori']][$row['bulan']] = $row['total_dana'];
    if (!in_array($row['bulan'], $months)) {
        $months[] = $row['bulan'];
    }
}

$response = [
    'months' => $months,
    'datasets' => []
];

foreach ($categories as $category => $values) {
    $dataset = [
        'label' => $category,
        'data' => [],
        'backgroundColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))
    ];
    foreach ($months as $month) {
        $dataset['data'][] = isset($values[$month]) ? $values[$month] : 0;
    }
    $response['datasets'][] = $dataset;
}

// Pass the data to JavaScript
$chartData = json_encode($response);
?>

<style>
    /* Flexbox layout to ensure footer is at the bottom */
    html {
        position: relative;
        min-height: 100%;
    }

    body {
        margin: 0;
        padding-bottom: 100px;
        /* Height of the footer */
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 70px;
        /* Set the height of your footer */
        text-align: center;
        padding-top: 30px;
        /* Adjust as needed */
    }

    .header {
        text-align: center;
        margin: 20px 0;
    }

    .data-table {
        margin-top: 20px;
    }

    .data-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .data-table th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <?php
    include 'includes/navbar.php';
    ?>

    <div class="content">
        <div class="container mt-5">
            <div class="header">
                <h2>Laporan Keuangan Masjid</h2>
                <p>Grafik ini menampilkan perkembangan keuangan masjid setiap bulannya</p>
            </div>

            <!-- Filter Section -->
            <div class="filter-section mb-4">
                <label for="categoryFilter">Category:</label>
                <select id="categoryFilter">
                    <option value="">All</option>
                    <?php
                    $categoryQuery = "SELECT id_kategori, nama_kategori FROM kategori";
                    $categoryResult = mysqli_query($conn, $categoryQuery);
                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                        echo "<option value='" . $category['id_kategori'] . "'>" . $category['nama_kategori'] . "</option>";
                    }
                    ?>
                </select>
                <label for="monthFilter">Month:</label>
                <select id="monthFilter">
                    <option value="">All</option>
                    <?php
                    foreach ($months as $month) {
                        echo "<option value='$month'>$month</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Chart Section -->
            <canvas id="financialChart"></canvas>

            <!-- Data Table Section -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Bulan</th>
                            <th>Total Dana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['nama_kategori']}</td>
                                    <td>{$row['bulan']}</td>
                                    <td>{$row['total_dana']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var data = <?php echo $chartData; ?>;
            var ctx = document.getElementById('financialChart').getContext('2d');
            var financialChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.months, // Labels for the X-axis
                    datasets: data.datasets // Data for the chart
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Dana'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Filter functionality
            $('#categoryFilter, #monthFilter').on('change', function() {
                var filteredData = JSON.parse('<?php echo $chartData; ?>');
                var selectedCategory = $('#categoryFilter').val();
                var selectedMonth = $('#monthFilter').val();

                filteredData.datasets = filteredData.datasets.filter(dataset => {
                    if (selectedCategory && dataset.label !== selectedCategory) {
                        return false;
                    }
                    return true;
                });

                if (selectedMonth) {
                    filteredData.labels = [selectedMonth];
                    filteredData.datasets.forEach(dataset => {
                        dataset.data = [dataset.data[filteredData.labels.indexOf(selectedMonth)]];
                    });
                }

                financialChart.data = filteredData;
                financialChart.update();
            });
        });
    </script>
</body>

</html>