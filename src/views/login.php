<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Brasa Bros</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="assets/styles/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
</head>

<body class="login-body-bg">
    <header class="header">
        <div class="logo_contenedor">
            <a href="index.php">
                <img src="assets/images/logo_pollo.png" alt="Logo Brasa Bros" class="logo_imagen" />
            </a>
            <a href="index.php" class="logo_texto">BRASA BROS</a>
        </div>

        <nav class="menu">
            <a href="index.php">Home</a>
            <a href="index.php?page=carta">Carta</a>
            <a href="index.php?page=delivery">Delivery</a>
            <a href="index.php?page=reserva" class="btnReservacion nav-reserva">RESERVACIÓN</a>
        </nav>
    </header>

    <main class="login-container">
        <div class="auth-card">
            <div class="auth-tabs">
                <button class="tab-btn active" onclick="switchTab(event, 'form-login')">Iniciar Sesión</button>
                <button class="tab-btn" onclick="switchTab(event, 'form-registro')">Registrarse</button>
            </div>

            <div class="auth-content">
                
                <form id="form-login" action="index.php?action=login" method="POST" class="auth-form active">
                    <label for="login-email">Correo Electrónico</label>
                    <input type="email" id="login-email" name="email" placeholder="ejemplo@correo.com" required>
                    
                    <label for="login-pass">Contraseña</label>
                    <input type="password" id="login-pass" name="password" placeholder="••••••••" required>
                    
                    <button type="submit" class="btn-login">INGRESAR</button>
                </form>

                <form id="form-registro" action="index.php?action=registro" method="POST" class="auth-form">
                    <label for="reg-nombre">Nombre Completo</label>
                    <input type="text" id="reg-nombre" name="nombre_completo" placeholder="Tu nombre" required>

                    <label for="reg-email">Correo Electrónico</label>
                    <input type="email" id="reg-email" name="email" placeholder="ejemplo@correo.com" required>
                    
                    <label for="reg-pass">Contraseña</label>
                    <input type="password" id="reg-pass" name="password" placeholder="Mínimo 6 caracteres" required>
                    
                    <button type="submit" class="btn-login">CREAR CUENTA</button>
                </form>

            </div>
        </div>
    </main>

    <footer class="pie-final">
        <p>© 2026 Restaurante Brasa Bros. Todos los derechos reservados.</p>
    </footer>

    <script>
        function switchTab(e, formId) {
           
            document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
            
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
            document.getElementById(formId).classList.add('active');
            e.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>