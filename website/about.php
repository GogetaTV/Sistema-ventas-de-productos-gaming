<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Seccion nosotros-->

<section class="about">

    <div class="row">

    <div class="image">

        <img src="images/about-img.png" alt="">

    </div>

    <div class="content">
        <h3>Porque nos escogerias?</h3>
        <p>1.- Especialización en productos gamer: Gamestore se enfoca exclusivamente en periféricos para juegos, lo que garantiza una selección especializada y de alta calidad para los entusiastas de los videojuegos.</p>
        <p>2.- Variedad de productos: Ofrece una amplia gama de periféricos, desde teclados y ratones hasta auriculares y sillas ergonómicas, cubriendo las necesidades de los gamers en términos de comodidad, rendimiento y estilo.</p>
        <p>3.- Atención y conocimiento especializado: El personal de Gamestore está capacitado para brindar asesoramiento técnico y conocimiento detallado sobre los productos, asegurando que los clientes tomen decisiones informadas y encuentren lo que mejor se adapte a sus necesidades.</p>
        <p>4.- Relación con la comunidad gamer: Gamestore puede establecer vínculos con la comunidad gamer a través de eventos, patrocinios o promociones especiales, fortaleciendo su presencia en el mercado y generando fidelidad entre los jugadores.</p>
        <p>5.- Enfoque en la experiencia del cliente: La tienda se dedica a proporcionar una experiencia de compra placentera y personalizada para los gamers, ofreciendo un ambiente amigable y enfocado en sus intereses específicos.</p>
        <p>En resumen, Gamestore destaca por su enfoque especializado en productos gamer de calidad, conocimiento experto, amplia variedad y atención centrada en la satisfacción del cliente, convirtiéndola en una opción atractiva para los amantes de los videojuegos en busca de periféricos de alto rendimiento.</p>
        <a href="contact.php" class='btn'>Contactanos</a>

    </div>

    </div>


</section>

<!-- Seccion nosotros-->

<!-- Seccion reseñas-->

<div class="section reviews">
    <h1 class="heading">Reseñas del cliente</h1>
    <div class="swiper reviews-slider">
        
    <div class="swiper-wrapper">

    <div class="swiper-slide slide">
        <img src="images/pic-1.png" alt="">
        <p>Gamestore superó mis expectativas. Encontré todo lo que necesitaba para mi configuración gamer. El personal fue amable, conocedor y me ayudó a elegir el equipo perfecto. ¡Definitivamente regresaré!</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Juan Quevedo</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-2.jpg" alt="">
        <p>Quedé impresionado por la amplia gama de productos de alta calidad en Gamestore. Desde teclados hasta auriculares, tenían todo lo que un gamer podría desear. ¡Excelente selección!</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <h3>Martin Cabañas</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-3.jpg" alt="">
        <p>La atención y el conocimiento del personal de Gamestore son excepcionales. Me orientaron en la compra de un mouse específico para mis necesidades de juego. ¡Una experiencia de compra muy satisfactoria!</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <h3>Hans Alava</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-4.png" alt="">
        <p> Gamestore no solo vende productos, también conecta con la comunidad gamer. Organizan eventos y promociones que demuestran su compromiso con los jugadores. ¡Gran lugar para cualquier entusiasta de los videojuegos!</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Luis Ponte</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-5.png" alt="">
        <p> La atención al cliente en Gamestore es destacable. Eficaz y rapido. Comprar aquí fue fácil y cómodo. ¡Altamente recomendado para cualquier jugador en busca de equipos de calidad!</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Pedro Atencia</h3>
    </div>

    </div>

    <div class="swiper-pagination"></div>

    </div>
</div>

<!-- Seccion reseñas-->

















<?php include 'components/footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!--Links de js personalizados -->

<script src="js/script.js"></script>

<script>
     var swiper = new Swiper(".reviews-slider", {
      loop:true,
      grabCursor:true,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        550: {
            slidesPerView: 2,
        },
        768:{
            slidesPerView: 2,
        },
        1024:{
            slidesPerView: 3,
        },
      }
    });
</script>
    
</body>
</html>