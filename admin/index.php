<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI Masjid</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


</head>
<style>
    /* Custom styles for this template */
    body {
        font-size: .875rem;
    }

    .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
    }

    /*
 * Sidebar
 */

    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        /* Behind the navbar */
        padding: 48px 0 0;
        /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 5rem;
        }
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto;
        /* Scrollable contents if viewport is shorter than content. */
    }

    @supports ((position: -webkit-sticky) or (position: sticky)) {
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
    }

    .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #727272;
    }

    .sidebar .nav-link.active {
        color: #007bff;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }

    /*
 * Navbar
 */

    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        background-color: rgba(0, 0, 0, .25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
    }

    .navbar .navbar-toggler {
        top: .25rem;
        right: 1rem;
    }

    .navbar .form-control {
        padding: .75rem 1rem;
        border-width: 0;
        border-radius: 0;
    }

    .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
    }

    .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
    }
</style>
<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
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
                        <a class="nav-link active" aria-current="page" href="blog/index.php">
                            <span data-feather="file" class="align-text-bottom"></span>
                            Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="buku/index.php">
                            <span data-feather="book" class="align-text-bottom"></span>
                            Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dana/index.php">
                            <span data-feather="dollar-sign" class="align-text-bottom"></span>
                            Dana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="donasi/index.php">
                            <span data-feather="gift" class="align-text-bottom"></span>
                            Donasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="galeri/index.php">
                            <span data-feather="image" class="align-text-bottom"></span>
                            Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="kategori/index.php">
                            <span data-feather="layers" class="align-text-bottom"></span>
                            Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="kegiatan/index.php">
                            <span data-feather="activity" class="align-text-bottom"></span>
                            Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="komentar/index.php">
                            <span data-feather="message-square" class="align-text-bottom"></span>
                            Komentar Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="transaksi/index.php">
                            <span data-feather="dollar-sign" class="align-text-bottom"></span>
                            Transaksi
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


        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar" class="align-text-bottom"></span>
                        This week
                    </button>
                </div>
            </div>

            <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->



        </main>
    </div>
</div>


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
</body>

</html>