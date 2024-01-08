<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<?php include '../components/admin_header.php' ?>


<!-- Seccion panel de administrador -->

<section class="dashboard">

    <h1 class="heading">dashboard</h1>

    <div class="box-container">

    <div class="box">
        <h3>Bienvenido!</h3>
        <p><?= $fetch_profile['name']; ?></p>
        <a href="update_profile.php" class="btn">Actualizar Perfil</a>
        
    </div>
    <div class="box">
        <?php
           $total_pendings = 0;
           $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
           $select_pendings->execute(['pendiente']);
           while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings  += $fetch_pendings['total_price'];
           }
        ?>
        <h3><span>S/.</span><?= $total_pendings; ?><span></span></h3>
        <p>Total Pendientes</p>
        <a href="placed_orders.php" class="btn">Ver ordenes pendientes</a>


    </div>

    <div class="box">
        <?php
           $total_completes = 0;
           $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
           $select_completes->execute(['completado']);
           while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes  += $fetch_completes['total_price'];
           }
        ?>
        <h3><span>S/.</span><?= $total_completes; ?><span></span></h3>
        <p>Total Completados</p>
        <a href="placed_orders.php" class="btn">Ver ordenes completadas</a>


    </div>

    <div class="box">
        <?php
           $select_orders = $conn->prepare("SELECT * FROM `orders`");
           $select_orders->execute();
           $numbers_of_orders= $select_orders->rowCount();
        ?>
        <h3><?= $numbers_of_orders; ?></h3>
        <p>Ordenes Totales</p>
        <a href="placed_orders.php" class="btn">Ver Ordenes</a>
    </div>

    <div class="box">
        <?php
           $select_products = $conn->prepare("SELECT * FROM `products`");
           $select_products->execute();
           $numbers_of_products= $select_products->rowCount();
        ?>
        <h3><?= $numbers_of_products; ?></h3>
        <p>Productos Añadidos</p>
        <a href="products.php" class="btn">Ver Productos</a>
    </div>

    <div class="box">
        <?php
           $select_users = $conn->prepare("SELECT * FROM `users`");
           $select_users->execute();
           $numbers_of_users= $select_users->rowCount();
        ?>
        <h3><?= $numbers_of_users; ?></h3>
        <p>Cuentas de Usuario</p>
        <a href="users_accounts.php" class="btn">Ver Usuarios</a>
    </div>

    <div class="box">
        <?php
           $select_admins = $conn->prepare("SELECT * FROM `admins`");
           $select_admins->execute();
           $numbers_of_admins= $select_admins->rowCount();
        ?>
        <h3><?= $numbers_of_admins; ?></h3>
        <p>Total Administradores</p>
        <a href="admin_accounts.php" class="btn">Ver Administradores</a>
    </div>

    <div class="box">
        <?php
           $select_messages = $conn->prepare("SELECT * FROM `messages`");
           $select_messages->execute();
           $numbers_of_messages = $select_messages->rowCount();
        ?>
        <h3><?= $numbers_of_messages; ?></h3>
        <p>Nuevos mensajes</p>
        <a href="messages.php" class="btn">Ver Mensajes</a>
    </div>

    </div>

</section>



<!-- Seccion panel de administrador -->







<!--Links de js personalizados -->

<script src="../js/admin_script.js"></script>

</body>
</html>