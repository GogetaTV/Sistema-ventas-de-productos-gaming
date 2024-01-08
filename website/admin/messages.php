<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Seccion de mensajes -->

<section class="messages">
    
    <h1 class="heading">Nuevo mensajes</h1>

    <div class="box-container">

    <?php
       $select_messages = $conn->prepare("SELECT * FROM `messages`");
       $select_messages->execute();
       if ($select_messages->rowCount() > 0){
           while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
        <p> ID Usuario : <span><?= $fetch_messages['user_id'] ?></span> </p>
        <p> Nombre : <span><?= $fetch_messages['name'] ?></span> </p>
        <p> Numero : <span><?= $fetch_messages['number'] ?></span> </p>
        <p> E-mail : <span><?= $fetch_messages['email'] ?></span> </p>
        <p> Mensaje : <span><?= $fetch_messages['message'] ?></span> </p>
        <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Eliminar este mensaje?');">delete</a>
    </div>
    <?php
           }
        }else{
            echo '<p class="empty">Aun no tienes mensajes</p>';
        }
    ?>
    </div>

</section>

<!-- Seccion de mensajes -->







<!--Links de js personalizados -->

<script src="../js/admin_script.js"></script>

</body>
</html>