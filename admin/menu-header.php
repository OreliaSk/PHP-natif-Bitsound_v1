<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Bitsound.</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a class="nav-link" href="logout.php">Se déconnecter</a>
    </li>
    </ul>
</nav>
	
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span data-feather="home"></span>
                        Dashboard <span class="sr-only">(current)</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="articles.php">
                        <span data-feather="file"></span>
                        Articles
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="artists.php">
                        <span data-feather="users"></span>
                        Artistes
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="festivals.php">
                        <span data-feather="bar-chart-2"></span>
                        Festivales
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <span data-feather="layers"></span>
                        Administrateurs
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../" target="_blank">
                        <span data-feather="bar-chart-2"></span>
                        Retourner sur le site
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <span data-feather="bar-chart-2"></span>
                        Se déconnecter
                    </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                    <button class="btn btn-sm btn-outline-secondary">Share</button>
                    <button class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                    </button>
                </div>
            </div>