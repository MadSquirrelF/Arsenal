<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:admin_login.php');
}
if(isset($_POST['update'])){

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
 
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $pid]);
 
    $message[] = 'Товар успешно изменен!';
 
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;
 
    if(!empty($image)){
       if($image_size > 2000000){
          $message[] = 'Размер изображения слишком большой!';
       }else{
          $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
          $update_image->execute([$image, $pid]);
          move_uploaded_file($image_tmp_name, $image_folder);
          unlink('../uploaded_img/'.$old_image);
          $message[] = 'Изображение успешно обновлено!';
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
    <title>ООО Арсенал - Редактировать товар</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../images/54.png" type="image/x-icon">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">

</head>
<body class="body">
<?php include '../components/admin_header.php'?>

<section class="update-product">

    <h1 class="heading">Редактирование товара</h1>
    
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
    
    <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
        <div class="main-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         </div>
         <div class="user-box">
          <input type="text" name="name" required class="box" maxlength="100"  value="<?= $fetch_products['name']; ?>">
          <label>Обновить название</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="number" name="price" required class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
          <label>Обновить цену</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <textarea name="details" class="box" required cols="30" rows="5"><?= $fetch_products['details']; ?></textarea>
          <label>Обновить описание</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
          <label>Обновить изображение</label>
        </div>
        <!-- /.user-box -->
        <div class="flex-btn">
          <input type="submit" name="update" class="btn" value="Обновить">
          <a href="products.php" class="option-btn">Вернуться обратно</a>
      </div>
        </div>
        
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">Товар не найден!</p>';
      }
   ?>

</section>
   
<script src="../js/admin_script.js" ></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>