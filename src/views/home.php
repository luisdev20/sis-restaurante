<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurante Brasa Bros</title>
  <link rel="stylesheet" href="assets/styles/main.css" />
</head>

<body>
  <header class="header">
    <div class="logo_contenedor">
      <a href="index.php"><img src="assets/images/logo_pollo.png" alt="Logo Brasa Bros" class="logo_imagen" /></a>
      <a href="index.php" class="logo_texto">BRASA BROS</a>
    </div>

    <nav class="menu">
      <a href="index.php?page=carta">Carta</a>
      <a href="index.php?page=delivery">Delivery</a>
      <a href="index.php?page=reserva" class="nav-reserva">Reserva</a>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div class="hero-contenido">
        <h1>BRASA BROS</h1>
        <p>Pollos a la Brasa & Parrillas con el poder del fuego</p>
        <a href="index.php?page=reserva" class="btnReservacion">RESERVACIÓN</a>
      </div>
    </section>
  </main>

  <section class="contenido">
    <h2>Bienvenidos a Restaurante Brasa Bros</h2>
    <p>
      Disfruta de la mejor comida a la brasa en un ambiente acogedor y
      familiar. Nuestro menú ofrece una variedad de platos deliciosos
      preparados con ingredientes frescos y de alta calidad. ¡Ven y vive una
      experiencia culinaria inolvidable!
    </p>
  </section>
  <section class="multimedia">
    <h3>Nuestra Especialidad</h3>
    <video controls width="100%" poster="assets/images/video_pollo.jpg">
      <source src="assets/videos/video_restaurante.mp4" type="video/mp4" />
    </video>

    <p>Escucha el sonido del sabrosura:</p>
    <audio controls>
      <source src="assets/audio/audio-papas.mp3" type="audio/mpeg" />
    </audio>
  </section>

  <section class="horarios">
    <h2>Horarios de Atención</h2>
    <div class="tabla-contenedor">
      <table>
        <thead>
          <tr>
            <th>Día</th>
            <th>Almuerzo</th>
            <th>Cena</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Lunes a Jueves</td>
            <td>12:00 PM - 4:00 PM</td>
            <td>6:30 PM - 10:00 PM</td>
          </tr>
          <tr>
            <td>Viernes y Sábados</td>
            <td>12:00 PM - 5:00 PM</td>
            <td>6:00 PM - 11:30 PM</td>
          </tr>
          <tr>
            <td>Domingos y Feriados</td>
            <td colspan="2">11:30 AM - 9:00 PM (Horario corrido)</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <section class="ubicacion">
    <div class="ubicacion-info">
      <h4>Encuéntranos en:</h4>

      <a href="https://www.google.com/maps?q=Av.+Principal+123,+Ciudad+Brasa" target="_blank" class="ubicacion-link">
        <img src="assets/images/maps.png" alt="Google Maps" class="icono-maps" />
        <span>Av. Principal 123, Ciudad Brasa</span>
      </a>
    </div>

    <div class="pagos">
      <h4>Medios de pago:</h4>

      <div class="pagos-iconos">
        <img src="assets/images/visa.png" alt="Visa" />
        <img src="assets/images/mastercard.png" alt="Mastercard" />
        <img src="assets/images/yape.png" alt="Yape" />
        <img src="assets/images/plin.png" alt="Plin" />
      </div>
    </div>
  </section>
</body>

<footer>
  <p>&copy; 2026 Restaurante Don Brasa. Todos los derechos reservados.</p>
</footer>

</html>