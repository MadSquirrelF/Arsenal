<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
};
if(isset($_POST['update_payment'])){
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment->execute([$payment_status, $order_id]);
    $message[] = 'Статус заказа изменен!';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');
    $message[] = 'Заказ удален!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Данные заказа</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>#
<section class="orders">
  <h1 class="heading">Размещенные заказы</h1>
  
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
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
      <p> ФИО :<br> <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Номер телефона :<br>  <span><?= $fetch_orders['number']; ?></span> </p>
      <p> E-mail :<br>  <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Адресс :<br>  <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Всего заказано :<br>  <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Общая цена :<br>  <span><?= $fetch_orders['total_price']; ?> руб</span> </p>
      <p> Способ оплаты :<br>  <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="В ожидании">В ожидании</option>
            <option value="Завершен">Завершен</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Обновить" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Вы действительно хотите удалить данный заказ?');">Удалить</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Заказов пока нет!</p>';
      }
   ?>

</div>
<!-- /.box-container -->



</section>
<!-- /.orders -->
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>