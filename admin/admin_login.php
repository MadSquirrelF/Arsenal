<?php
include '../components/connect.php';
session_start();
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass,FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin->execute([$name,$pass]);
    
    if($select_admin->rowCount() > 0){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] =  $fetch_admin_id['id'];
        header('location:dashboard.php');
    }else{
        $message[] = 'Неправильное имя пользователя или пароль!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Вход админа</title>
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">
</head>
<body>
    

    
<!--admin login form section starts -->
<section class="form-container" >
<h1 class="heading">Войти<br> в панель управления</h1>
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
        <input type="text" name="name" maxlength="20"
        required   class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Имя пользователя</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="pass" maxlength="50"
        required class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Пароль</label>
        </div>
        <!-- /.user-box -->
       

        <input type="submit" value="Войти" name="submit" class="btn-login">
       </form>
   </div>
   <!-- /.row -->
</section>
<!--admin login form section ends -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>