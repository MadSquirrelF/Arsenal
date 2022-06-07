<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
}
if(isset($_POST['submit'])){
    $empty_name = '';
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);
    if($name == $empty_name){
        $message[] = 'Имя не может быть пустым!';
    }else{
        $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
        $update_name->execute([$name,$admin_id]);
    }
    
    
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

    $select_old_pass = $conn->prepare("SELECT password FROM `admins` WHERE id = ? ");
    $select_old_pass->execute([$admin_id]);

    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];

    $old_pass =  sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass,FILTER_SANITIZE_STRING);

    $new_pass =  sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass,FILTER_SANITIZE_STRING);

    $con_pass =  sha1($_POST['con_pass']);
    $con_pass = filter_var($con_pass,FILTER_SANITIZE_STRING);
    
    if($old_pass == $empty_pass){
        $message[] = 'Пожалуйста введите старый пароль!';
    }elseif($old_pass != $prev_pass){
        $message[] = 'Ваш старый пароль введен некорректно!';
    }elseif($new_pass != $con_pass ){
        $message[] = 'Ваш подтвержденный пароль введен некорректно!';
    }else{
        if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_pass->execute([$con_pass, $admin_id]);
            $message[] = 'Пароль успешно изменен!';
        }
        else{
            $message[] = 'Пожалуйста введите НОВЫЙ пароль!';
        }
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Редактировать данные админа</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>

<!--admin update form section starts -->
<section class="form-container">
<ion-icon class="bg-icon" name="create-outline"></ion-icon>
<h1 class="heading">Редактирование профиля</h1>
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
        <input type="text" name="name" maxlength="20" class="box" required
        oninput="this.value = this.value.replace(/\s/g, '')" value="<?$fetch_profile['name'];?>">
        <label>Имя пользователя</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="old_pass" maxlength="50" class="box" required
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Старый пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="new_pass" maxlength="50" required
          class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Новый пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="con_pass" maxlength="50" required
          class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Подтвердите новый пароль</label>
        </div>
        <!-- /.user-box -->
       

        

        

        
        
      

        <input type="submit" value="Обновить данные" name="submit" class="btn-login">
       </form>
   </div>
   <!-- /.row -->
   
   
</section>
<!--admin update form section ends -->

   

   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>