<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Панель Администратора</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>



<section class="dashboard">
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



    <h1 class="heading">Общая статистика</h1>


    <div class="box-container">
    <div class="box">
    <h3>Добро пожаловать!</h3>
    <p>Имя Администратора:<br><?= $fetch_profile['name']; ?></p>
    <a href="update_profile.php" class="btn-login">Редактировать<br> профиль</a>
   
    </div>
    <!-- /.box -->
    <div class="box">
        <?php
             $total_pendings = 0;
             $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ");
             $select_pendings->execute(['В ожидании']);
             while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                 $total_pendings += $fetch_pendings['total_price'];
             }
        ?>
        <h3><span>/- </span><?= $total_pendings; ?><span> рублей</span></h3>
        <p>Всего в ОЖИДАНИИ на<br>  сумму</p>
        <a href="placed_orders.php" class="btn-login">Посмотреть<br> заказы</a>
    </div>
    <!-- /.box -->
    <div class="box">
        <?php
             $total_completes = 0;
             $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ");
             $select_completes->execute(['Завершен']);
             while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                 $total_completes += $fetch_completes['total_price'];
             }
        ?>
        <h3><span>/- </span><?= $total_completes; ?><span> рублей</span></h3>
        <p>Всего КУПЛЕНО на<br> сумму</p>
        <a href="placed_orders.php" class="btn-login">Посмотреть<br> заказы</a>
    </div>
    <!-- /.box -->
    <div class="box">
        <?php
        $select_orders = $conn->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        $numbers_of_orders = $select_orders->rowCount();
        ?>
        <h3><?= $numbers_of_orders; ?></h3>
        <p>Количество<br> заказов</p>
        <a href="placed_orders.php" class="btn-login">Посмотреть<br> заказы</a>

    </div>
    <!-- /.box -->
    <div class="box">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products`");
        $select_products->execute();
        $numbers_of_products = $select_products->rowCount();
        ?>
        <h3><?= $numbers_of_products; ?></h3>
        <p>Количество товаров добавленных</p>
        <a href="products.php" class="btn-login">Посмотреть<br> товары</a>

    </div>
    <!-- /.box -->
    <div class="box">
        <?php
        $select_users = $conn->prepare("SELECT * FROM `users`");
        $select_users->execute();
        $numbers_of_users = $select_users->rowCount();
        ?>
        <h3><?= $numbers_of_users; ?></h3>
        <p>Пользователь зарегестрировалось</p>
        <a href="users_accounts.php" class="btn-login">Посмотреть<br> пользователь</a>

    </div>
    <!-- /.box -->
    <div class="box">
        <?php
        $select_admins = $conn->prepare("SELECT * FROM `admins`");
        $select_admins->execute();
        $numbers_of_admins = $select_admins->rowCount();
        ?>
        <h3><?= $numbers_of_admins; ?></h3>
        <p>Админов<br> существует</p>
        <a href="admin_accounts.php" class="btn-login">Посмотреть<br> Админов</a>

    </div>
    <!-- /.box -->
    <div class="box">
        <?php
        $select_messages = $conn->prepare("SELECT * FROM `messages`");
        $select_messages->execute();
        $numbers_of_messages = $select_messages->rowCount();
        ?>
        <h3><?= $numbers_of_messages; ?></h3>
        <p>Всего <br>писем</p>
        <a href="messages.php" class="btn-login">Посмотреть<br> письма</a>

    </div>
    <!-- /.box -->

    </div>
    <!-- /.box-container -->
   
    
</section>
   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>