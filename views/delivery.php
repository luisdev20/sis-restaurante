<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delivery | Brasa Bros</title>
  <link rel="stylesheet" href="../public/assets/styles/delivery.css" />
</head>
<body>
<header>
  <h1>Delivery Brasa Bros</h1>
</header>
<main>

  <section class="delivery-info">
    <img src="../public/assets/images/Pollo-a-la-braza-4-1.jpg" alt="Pollo a la brasa" />

    <div class="delivery-texto">
      <p>El auténtico pollo a la brasa, directo a tu mesa</p>
      <hr />
      <p>
        Realiza tu pedido para delivery dejando tus datos. Nos comunicaremos
        contigo para confirmar la orden y el tiempo de entrega.
      </p>
      <div class="delivery-feature">
        <img src="../public/assets/images/Delivery.png" alt="Delivery" />
        <div>
          <h3>Entrega rápida y segura</h3>
          <p>Llevamos tu pedido caliente</p>
        </div>
      </div>
    </div>
  </section>

  <section class="promociones">
    <h2>Promociones</h2>
    <div class="productos">
      <div class="producto">
        <img src="../public/assets/images/polloalabrasa4k.jpg" />
        <h3>Combo Festín</h3>
        <p>1 pollo a la brasa + papas familiares
          + ensalada fresca familiar + 1 bot. gaseosa 1.5L + salsas </p>
        <h3>S/ 80,90</h3>
        <p>Click para ordenar</p>
      </div>
      <div class="producto">
        <img src="../public/assets/images/polloalabrasa4k.jpg" />
        <h3>Combo Familiar</h3>
        <p>1/2 Pollo a la brasa con papas fritas + ensalada personal+0.5L bot gaseosa </p>
        <h3>S/ 45,00</h3>
        <p>Click para ordenar</p>
      </div>
      <div class="producto">
        <img src="assets/PolloPersonal.png" />
        <h3>Promo Personal</h3>
        <p>1/4 Pollo a la brasa con papas fritas + ensalada personal+625mL bot gaseosa</p>
        <h3>S/ 20,90</h3>
        <p>Click para ordenar</p>
      </div>
      <div class="producto">
        <img src="assets/ParrillaRe.png" />
        <h3>Lomo Real</h3>
        <p>Lomo fino a la parrilla a nuestro estilo. Acompañado con papas + ensalada </p>
        <h3>S/ 45,90</h3>
        <p>Click para ordenar</p>
      </div>
      <div class="producto">
        <img src="assets/ParrillaPersonal.png" />
        <h3>Parrilla Personal</h3>
        <p> 1/4 de Pollo a la Brasa +Costilla de Cerdo a la BBQ + 2 salchichas + Ensalada </p>
        <h3>S/ 40,90</h3>
        <p>Click para ordenar</p>
      </div>
      <div class="producto">
        <img src="assets/ParrillaPollo.png" />
        <h3>Filete de Pollo Light</h3>
        <p> Filete de pollo de 300gr con guarnición de lechuga y espinaca</p>
        <h3>S/ 20,40</h3>
        <p>Click para ordenar</p>
      </div>
    </div>
  </section>

  <section class="formulario" id="formulario">
    <div class="producto-seleccionado" id="producto-seleccionado">
      <h3>Producto seleccionado: <span id="nombre-producto"></span></h3>
      <p>Completa tus datos para continuar</p>
    </div>

    <form action="/delivery" method="POST">
      <label for="nombre">Nombre Completo:</label>
      <input type="text" id="nombre" name="nombre" required />

      <label for="telefono">Número de Teléfono:</label>
      <input type="tel" id="telefono" name="telefono" required />

      <label for="direccion">Dirección de Entrega:</label>
      <input type="text" id="direccion" name="direccion" required />

      <label for="referencia">Referencia (opcional):</label>
      <input type="text" id="referencia" name="referencia" />

      <label>Método de pago:</label>

      <label class="radio-opcion">
        <input type="radio" name="pago" value="efectivo" checked />
        <strong>Efectivo</strong> - Pago al momento de la entrega
      </label>

      <label class="radio-opcion">
        <input type="radio" name="pago" value="yape" />
        <strong>Yape / Plin</strong> - Transferencia digital
      </label>

      <label class="radio-opcion">
        <input type="radio" name="pago" value="tarjeta" />
        <strong>Tarjeta débito/crédito</strong> - Pago con POS al entregar
      </label>

      <button type="submit">ENVIAR PEDIDO</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2026 Restaurante Brasa Bros. Todos los derechos reservados.</p>
  </footer>

  <script>
    
    document.getElementById("formulario").style.display = "none";
    document.getElementById("producto-seleccionado").style.display = "none";

    
    var productos = document.querySelectorAll(".producto");
    for (var i = 0; i < productos.length; i++) {
      productos[i].onclick = function () {
        var nombre = this.querySelector("h3").textContent;
        document.getElementById("nombre-producto").textContent = nombre;
        document.getElementById("producto-seleccionado").style.display =
          "block";
        document.getElementById("formulario").style.display = "block";
        document.getElementById("formulario").scrollIntoView({
          behavior: "smooth",
        });
      };
    }
  </script>
  </body>

</html>