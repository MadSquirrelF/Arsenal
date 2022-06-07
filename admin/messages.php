<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
};
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    $message[] = 'Письмо успешно удалено!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Письма пользователей</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>

<section class="contacts">
    <h1 class="heading">Письма пользователей</h1>
    <div class="box-container">
    <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
     ?>
     <div class="box">
       <p> ID Пользователя :<br> <span><?= $fetch_message['user_id']; ?></span></p>
       <p> Имя :<br>  <span><?= $fetch_message['name']; ?></span></p>
       <p> Почта :<br>  <span><?= $fetch_message['email']; ?></span></p>
       <p> Номер телефона :<br>  <span><?= $fetch_message['number']; ?></span></p>
       <p> Сообщение :<br>  <span><?= $fetch_message['message']; ?></span></p>
       <a href="messages.php??delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Удалить данное сообщение?');" class="delete-btn">Удалить сообщение</a>
   </div>
    </div>
    
   <?php
         }
      }else{
         echo '<p class="empty">Новый писем нет!</p>';
      }
   ?>
</section>
   
    
   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>