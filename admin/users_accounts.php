<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
};
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delete_id]);

    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_order->execute([$delete_id]);

    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);

    $delete_messages = $conn->prepare("DELETE FROM `messagest` WHERE user_id = ?");
    $delete_messages->execute([$delete_id]);
    $message[] = 'Пользователь успешно удален!';

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Аккаунт пользователя</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>

<section class="accounts">
    <h1 class="heading">Аккаунты пользователей</h1>
    
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
    <div class="box-container">
        <?php
        $select_accounts = $conn->prepare("SELECT * FROM `users`");
        $select_accounts->execute();
        if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
        ?>
        <div class="box">
        <div class="imgBx">
             <ion-icon name="person-circle-outline"></ion-icon>
        </div>
          <!-- /.imgBx -->
        <div class="contentBx">
          <p> ID ПОЛЬЗОВАТЕЛЯ : <span><?= $fetch_accounts['id']; ?></span> </p>
          <p> ИМЯ ПОЛЬЗОВАТЕЛЯ : <span><?= $fetch_accounts['name']; ?></span> </p>
        </div>
        <!-- /.contentBx -->
        <div class="flex-btn">
         <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>"
          onclick="return confirm('Вы действительно хотите удалить аккаунт?')" 
          class="delete-btn">Удалить</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Нет доступных аккаунтов!</p>';
      }
   ?>
    </div>
    <!-- /.box-container -->
</section>
<!-- /.accounts -->
   
    

   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>