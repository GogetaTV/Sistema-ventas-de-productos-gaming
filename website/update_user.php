<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare('SELECT password FROM `users` WHERE id = ?');
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if($old_pass == $empty_pass){
        $message[] = 'Porfavor ingrese la antigua contraseña!';
    }elseif($old_pass != $prev_pass){
        $message[] = 'La antigua contraseña no coincide!';
    }elseif($new_pass != $confirm_pass){
        $message[] = 'Las nuevas contraseñas no coinciden!';
    }else{
        if($new_pass != $empty_pass){
           $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
           $update_pass->execute([$confirm_pass, $user_id]);
           $message[] = 'Contraseña actualizada exitosamente!';
        }else{
            $message [] = 'Porfavor ingrese una nueva contraseña!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar perfil</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Seccion actualizar cuenta de usuario -->

<section class="form-container">
    <form action="" method="POST">
        <h3>Actualizar perfil</h3>
        <input type="text" required maxlength="20" name="name" placeholder="Ingrese su nombre" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name']; ?>">
        <input type="email" required maxlength="50" name="email" placeholder="Ingrese su e-mail" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['email']; ?>">
        <input type="password" maxlength="20" name="old_pass" placeholder="Ingrese su antigua contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" maxlength="20" name="new_pass" placeholder="Ingrese su nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" maxlength="20" name="confirm_pass" placeholder="Confirme su nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Actualizar ahora" class="btn" name="submit">
    </form>

</section>

<!-- Seccion actualizar cuenta de usuario -->
















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>