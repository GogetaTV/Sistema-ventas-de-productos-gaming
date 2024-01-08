<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

include 'components/whishlist_cart.php'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="home-bg">
    <section class="swiper home-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/home-img-1.png" alt="">
                </div>
                <div class="content">
                    <span>Hasta 50% de descuento</span>
                    <h3>En teclado gaming</h3>
                    <a href="shop.php" class="btn">Comprar ahora</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/home-img-2.png" alt="">
                </div>
                <div class="content">
                    <span>Hasta 50% de descuento</span>
                    <h3>En mouse gaming</h3>
                    <a href="shop.php" class="btn">Comprar ahora</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/home-img-3.png" alt="">
                </div>
                <div class="content">
                    <span>Hasta 50% de descuento</span>
                    <h3>En auriculares</h3>
                    <a href="shop.php" class="btn">comprar ahora</a>
                </div>
            </div>

        </div>

        <div class="swiper-pagination"></div>

    </section>

</div>

<!-- Seccion categoria de la pagina principal -->

<section class="home-category">

    <h1>Comprar por categoría</h1>

    <div class="swiper category-slider">

    <div class="swiper-wrapper">

    <a href="category.php?category=Teclado" class="swiper-slide slide">
        <img src="images/icon-1.png" alt="">
        <h3>Teclados</h3>
    </a>

    <a href="category.php?category=monitor" class="swiper-slide slide">
        <img src="images/icon-2.png" alt="">
        <h3>Monitores</h3>
    </a>

    <a href="category.php?category=webcam" class="swiper-slide slide">
        <img src="images/icon-3.png" alt="">
        <h3>Webcams</h3>
    </a>

    <a href="category.php?category=mouse" class="swiper-slide slide">
        <img src="images/icon-4.png" alt="">
        <h3>Mouses</h3>
    </a>

    <a href="category.php?category=auriculares" class="swiper-slide slide">
        <img src="images/icon-5.png" alt="">
        <h3>Auriculares</h3>
    </a>

    <a href="category.php?category=microfono" class="swiper-slide slide">
        <img src="images/icon-6.png" alt="">
        <h3>Microfonos</h3>
    </a>

    <a href="category.php?category=mousepad" class="swiper-slide slide">
        <img src="images/icon-7.png" alt="">
        <h3>Mousepads</h3>
    </a>

    <a href="category.php?category=wires" class="swiper-slide slide">
        <img src="images/icon-8.png" alt="">
        <h3>Cables</h3>
    </a>

    </div>

    <div class="swiper-pagination"></div>

    </div>

</section>

<!-- Seccion categoria de la pagina principal -->

<!-- Seccion productos de la pagina principal -->

<section class="home-products">
    <h1 class="heading">Ultimos productos</h1>

    <div class="swiper products-slider">

    <div class="swiper-wrapper">

    <?php
       $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
       $select_products->execute();
       if($select_products->rowCount() > 0){
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form action="" method="post" class="slide swiper-slide">
    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">
    <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>"  class="fas fa-eye"></a>
    <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" class ="image" alt="">
    <div class="name"><?= $fetch_products['name']; ?></div>
    <div class="flex">
        <div class="price">S/.<span><?= $fetch_products['price']; ?></span></div>
        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.lenght == 2) return false;">
    </div>
    <input type="submit" value="Añadir al carro" name="add_to_cart" class="btn">
    </form>

    <?php
       }
    }else{
        echo'<p class="empty">no prodducts added yet!</p>';
    }
    ?>

    </div>

    <div class="swiper-pagination"></div>
    
    </div>

</section>

<!-- Seccion productos de la pagina principal -->















<?php include 'components/footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!--Links de js personalizados -->

<script src="js/script.js"></script>

<script>
    var swiper = new Swiper(".home-slider", {
      loop:true,
      grabCursor:true,
      pagination: {
        el: ".swiper-pagination",
      },
    });

    var swiper = new Swiper(".category-slider", {
      loop:true,
      grabCursor:true,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        0: {
            slidesPerView: 2,
        },
        650:{
            slidesPerView: 3,
        },
        768:{
            slidesPerView: 4,
        },
        1024:{
            slidesPerView: 5,
        },
      }
    });

    var swiper = new Swiper(".products-slider", {
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