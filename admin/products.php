<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
};
if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price,FILTER_SANITIZE_STRING);

    $details = $_POST['details'];
    $details = filter_var($details,FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ? ");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'Товар с таким названием уже существует!';
    }else{
        $insert_product = $conn->prepare("INSERT INTO  `products`(name ,price ,details ,image ) VALUES(?,?,?,?)");
        $insert_product->execute([$name,$price,$details,$image]);
        if($insert_product){
            if($image_size > 2000000){
                $message[] = 'Размер изображения слишком большой!';
            }else{
                move_uploaded_file($image_tmp_name,$image_folder);
               
                $message[] = 'Новый товар успешно добавлен!';
            }
        }
        
    }
};
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    $message[] = 'Товар успешно удален!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО Арсенал - Товар и продукция</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>
<!--add products  section starts -->

<section class="add-products">
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
    <h1 class="heading">Добавление товара</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <img class="logo" src="../images/logo5.png" alt="">
        <div class="flex">
            <div class="inputBox">
                <input type="text" required name="name" maxlength="100" class="box">
                <label>Название</label>
            </div>
            <div class="inputBox">
                <input type="number" required min="0" max="9999999" name="price" onkeypress="if(this.value.length == 10) return false;"  class="box">
                <label>Цена</label>
            </div>
            <div class="inputBox">
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <label>Изображение </label>
            </div>
            <div class="inputBox">
                <textarea name="details" id="" maxlength="500" required class="box" cols="30" rows="4"></textarea>
                <label>Описание</label>
            </div>
            <input type="submit" value="Добавить товар" name="add_product" class="btn-login">
            
        </div>
    </form>

</section>
<!--add products  section starts -->

<section class="show-products">

   <h1 class="heading" style="margin-top:0;">Добавленный товар</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">Цена: <span><?= $fetch_products['price']; ?></span> рублей</div>
      <div class="details">Описание:<br> <span><?= $fetch_products['details']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Обновить</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Вы точно хотите удалить данный товар?');">Удалить</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Пока товар не добавлен!</p>';
      }
   ?>
   
   </div>

</section>
   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>