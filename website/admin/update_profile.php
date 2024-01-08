<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
    $update_name->execute([$name, $admin_id]);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `admins` WHERE id = ?");
    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
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
        $message[]= 'La antigua contraseña no coincide!';
    }elseif($new_pass != $confirm_pass){
        $message[] = 'Las nuevas contraseñas no coinciden!';
    }else{
        if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Contraseña actualizada exitosamente!';
        }else{
            $message[] = 'Porfavor ingrese la nueva contraseña!';
        }
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profileupdate</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Seccion para actualizar una cuenta administrador -->

<section class = "form-container">
    <form action="" method="POST">
        <h3>actualizar perfil</h3>
        <input type="text" name="name" maxlength="20" required placeholder="Ingresa tu nombre de usuario" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name']; ?>">
        <input type="password" name="old_pass" maxlength="20" placeholder="Ingrese su antigua contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="new_pass" maxlength="20" placeholder="Ingrese su nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirme su nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="actualizar ahora" name="submit" class="btn">
    </form>
</section>


<!-- Seccion para actualizar una cuenta administrador -->


<!--Links de js personalizados -->

<script src="../js/admin_script.js"></script>

</body>
</html>