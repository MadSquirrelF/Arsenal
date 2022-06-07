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
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);
 
    if($select_admin->rowCount() > 0){
       $message[] = 'Пользователь с таким именем уже существует!';
    }else{
       if($pass != $cpass){
          $message[] = 'Пароли не совпадают!';
       }else{
          $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
          $insert_admin->execute([$name, $cpass]);
          $message[] ='Новый аккаунт успешно создан!';
       }
    } 
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Регистрация админа</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>

<!--admin reg form section starts -->
<section class="form-container">
<h1 class="heading">Регистрация Администратора</h1>
<div class="error-message">
<?php
        if(isset($message)){
            foreach($message as $message){
                echo ' 
                <div class="message-box">
                <ion-icon class="mess" name="chatbox-ellipses"></ion-icon>
                <span>'.$message.'</span>
                <ion-icon class="del" name="close-circle" onclick="this.parentElement.remove();"></ion-icon>
                </div>
                <!-- /.message-box -->
                ';

            }
        }
?>
</div>
<!-- /.error-message -->
   <div class="row">
      <form action="" method="POST">
        <img src="../images/logo5.png" alt="">
        <div class="user-box">
        <input type="text" name="name" 
        required maxlength="20"  class="box" 
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Имя пользователя</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="pass" required  maxlength="20" 
         class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="cpass" required maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Подтвердите пароль</label>
        </div>
        <!-- /.user-box -->
        <input type="submit" value="Создать аккаунт" class="btn-login" name="submit">
       </form>
   </div>
   <!-- /.row -->
   
   
</section>
<!--admin reg form section ends -->

   
    

   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>