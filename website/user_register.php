<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'El usuario ya existe';
    }else{

        if($pass != $cpass){
            $message[] = 'Las contraseñas no coinciden';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?);");
            $insert_user->execute([$name, $email, $cpass]);  
            $message[] ='Registrado exitosamente, porfavor inicie sesión!';
        }

    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<!-- Seccion registrar nuevo usuario -->

<section class="form-container">
    <form action="" method="POST">
        <h3>Registrar ahora</h3>
        <input type="text" required maxlength="20" name="name" placeholder="Ingrese su nombre" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="email" required maxlength="50" name="email" placeholder="Ingrese su e-mail" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" required maxlength="20" name="pass" placeholder="Ingrese su contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" required maxlength="20" name="cpass" placeholder="Confirma tu contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Registrarme ahora" class="btn" name="submit">
        <p>Ya tienes una cuenta?</p>
        <a href="user_login.php" class="option-btn">Iniciar sesion</a>
    </form>

</section>

<!-- Seccion registrar nuevo usuario -->















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>