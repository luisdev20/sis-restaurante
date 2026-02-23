<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Brasa Bros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../../public/assets/styles/nosotros.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="home.php">
            <img src="../../public/assets/images/logo_pollo.png" alt="Logo" width="50" class="me-2">
            <span class="fw-bold">BRASA <span class="text-warning">BROS</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-uppercase small fw-bold">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="carta.php">La Carta</a></li>
                <li class="nav-item"><a class="nav-link active text-warning" href="nosotros.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-outline-warning btn-sm" href="reserva.php">RESERVATION</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="about-hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../../public/assets/images/polloalabrasa4k.jpg');">
    <div class="container text-center">
        <h1 class="display-2 fw-bold text-white">SOBRE NOSOTROS</h1>
        <h3 class="text-warning italic h5">"El mejor sabor de la zona, Brasa Bros"</h3>
    </div>
</section>

<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6 pe-lg-5">
            <h2 class="fw-bold display-6 mb-4">¿CÓMO EMPEZÓ?</h2>
            <p class="text-muted lead">Brasa Bros es una empresa que se formó con la pasión por el sabor tradicional. Empezamos como un pequeño sueño familiar y hoy somos el punto de encuentro favorito de la zona. A lo largo de este tiempo hemos mantenido la preferencia del público, quienes dicen que nuestro pollo es el más rico. Esto nos motiva a mejorar cada día.</p>
        </div>
        <div class="col-md-6">
            <img src="../../public/assets/images/historia.jpg" class="img-fluid rounded shadow-lg" alt="Nuestra Historia">
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <span class="material-symbols-outlined display-4 text-warning">restaurant</span>
                <h5 class="fw-bold mt-2">FOOD ALL DAY</h5>
                <p class="small text-muted">Sabor increíble disponible para ti todo el día.</p>
            </div>
            <div class="col-md-3">
                <span class="material-symbols-outlined display-4 text-warning">groups</span>
                <h5 class="fw-bold mt-2">CELEBRACIONES</h5>
                <p class="small text-muted">Reserva con nosotros para tus eventos privados.</p>
            </div>
            <div class="col-md-3">
                <span class="material-symbols-outlined display-4 text-warning">moped</span>
                <h5 class="fw-bold mt-2">DELIVERY</h5>
                <p class="small text-muted">Llegamos a tu casa con el pollo calientito.</p>
            </div>
            <div class="col-md-3">
                <span class="material-symbols-outlined display-4 text-warning">wifi</span>
                <h5 class="fw-bold mt-2">WIFI GRATIS</h5>
                <p class="small text-muted">Internet de alta velocidad para nuestros clientes.</p>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="../../public/assets/images/maps.png" class="img-fluid rounded shadow" alt="Mapa">
        </div>
        <div class="col-md-6 ps-lg-5">
            <h2 class="fw-bold">UBÍQUENOS</h2>
            <p class="text-muted">Visítanos en nuestro local principal o haz tu pedido online.</p>
            <hr class="text-warning">
            <p><strong>LIMA:</strong> (01) 521151</p>
            <p><strong>HORARIO:</strong> Lun a Dom - 10:00 am a 11:00 pm</p>
        </div>
    </div>
</section>

<footer class="bg-dark text-white py-4 border-top border-warning">
    <div class="container text-center">
        <p class="mb-0 small">COPYRIGHT &copy; 2026 BRASA BROS - Tercer Avance Ingeniería de Sistemas</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>