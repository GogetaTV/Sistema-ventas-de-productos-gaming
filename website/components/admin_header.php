<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">

    <section class="flex">

    <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

    <nav class="navbar">
        <a href="dashboard.php">Principal</a>
        <a href="products.php">Productos</a>
        <a href="placed_orders.php">Ordenes</a>
        <a href="admin_accounts.php">Administradores</a>
        <a href="users_accounts.php">Usuarios</a>
        <a href="messages.php">Mensajes</a>
    </nav>

    <div class="icons">
        <div id="menu-btn" class="fas fa-bars"></div>
        <div id="user-btn" class="fas fa-user"></div>
    </div>

    <div class="profile">
        <?php
           $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
           $select_profile->execute([$admin_id]);
           $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p><?= $fetch_profile['name']; ?></p>
        <a href="update_profile.php" class="btn">Actualizar mi Perfil</a>
        <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Iniciar sesion</a>
            <a href="register_admin.php" class="option-btn">Registrar nuevo</a>
        </div>
        <a href="../components/admin_logout.php" onclick="return confirm('Esta seguro de cerrar la sesion actual?');" class="delete-btn">Cerrar Sesion</a>
    </div>
    </section>

</header>