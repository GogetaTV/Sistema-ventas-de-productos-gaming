<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

if(isset($_POST['send'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number ,$msg]);

    if($select_message->rowCount() > 0){
        $message[] ='El mensaje ya se ah enviado!';
    }else{
        $send_message = $conn->prepare("INSERT INTO `messages`(name, email, number, message) VALUES(?,?,?,?)");
        $send_message->execute([$name, $email, $number, $msg]);
        $message [] = 'Mensaje enviado exitosamente';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Seccion contacto -->

<section class="form-container">

    <form method="post" action="" class="box">
        <h3>Envienos un mensaje</h3>
        <input type="text" name="name" required placeholder="Ingrese su nombre" maxlength="20" class="box">
        <input type="number" name="number" required placeholder="Ingrese su numero" max="999999999" min="0" class="box" onkeypress="if(this.value.length == 9) return false;">
        <input type="email" name="email" required placeholder="Ingrese su correo" maxlength="50" class="box">
        <textarea name="msg" placeholder="Ingrese su mensaje" required class="box" cols="30" rows="10"></textarea>
        <input type="submit" value="enviar mensaje" class="btn" name="send">
    </form>
</section>

<!-- Seccion contacto -->
















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>