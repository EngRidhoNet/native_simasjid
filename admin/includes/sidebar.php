

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../blog/index.php">
                    <span data-feather="file" class="align-text-bottom"></span>
                    Blog
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../buku/index.php">
                    <span data-feather="book" class="align-text-bottom"></span>
                    Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../dana/index.php">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    Dana
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../donasi/index.php">
                    <span data-feather="gift" class="align-text-bottom"></span>
                    Donasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../galeri/index.php">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Galeri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="layers" class="align-text-bottom"></span>
                    Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="activity" class="align-text-bottom"></span>
                    Kegiatan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="message-square" class="align-text-bottom"></span>
                    Komentar Blog
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    Pemasukan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Pengeluaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="book-open" class="align-text-bottom"></span>
                    Pinjaman Buku
                </a>
            </li>

        </ul>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
<script>
        /* globals Chart:false, feather:false */

        (function() {
            'use strict'

            feather.replace({
                'aria-hidden': 'true'
            })

            // Graphs
            var ctx = document.getElementById('myChart')
            // eslint-disable-next-line no-unused-vars
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        'Sunday',
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday'
                    ],
                    datasets: [{
                        data: [
                            15339,
                            21345,
                            18483,
                            24003,
                            23489,
                            24092,
                            12034
                        ],
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            })
        })()
</script>