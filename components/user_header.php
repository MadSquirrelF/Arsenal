<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
if(isset($_POST['registration'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email,]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $message[] = 'Пользователь с такой почтой уже существует!';
    }else{
       if($pass != $cpass){
          $message[] = 'Подтвержденный пароль не совпадает!';
       }else{
          $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
          $insert_user->execute([$name, $email, $cpass]);
          $message[] = 'Вы успешно зарегестрировались!Теперь войдите!';
       }
    }
 
};
if(isset($_POST['login'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION['user_id'] = $row['id'];
       $message[] = 'Вы вошли в систему!';
    }else{
       $message[] = 'Неправильно имя пользователя или пароль!';
    }
 
 };

 if(isset($_POST['update'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email,]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if(($email == NULL) || ($name == NULL)){
        $message[] = 'Введите имя или почту!';
    }elseif($select_user->rowCount() > 0){
        $message[] = 'Пользователь с такой почтой уже существует!';
    }
    else{
        $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
        $update_profile->execute([$name, $email, $user_id]);
        $message[] = 'Вы успешно сменили имя и почту!';
    }
   
 
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    if($old_pass == $empty_pass){
       $message[] = 'Введите старый пароль';
    }elseif($old_pass != $prev_pass){
       $message[] = 'Старый пароль не совпадает!';
    }elseif($new_pass != $cpass){
       $message[] = 'Подтверждающий пароль не сопадает!';
    }else{
       if($new_pass != $empty_pass){
          $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
          $update_admin_pass->execute([$cpass, $user_id]);
          $message[] = 'Данные успешно обновлены!';
       }else{
          $message[] = 'Введите Новый пароль!';
       }
    }
    
 };
?>

<div id="progress">
    <span id="progress-value">🚀</span>
</div>

<header class="header">
		<a href="main_page.php#Home" class="logo">
			<img src="img/logo5.png">
		</a>
		<nav class="navbar">
            <a href="main_page.php#About">О компании</a>
            <a href="main_page.php#Engineer">Инженерный центр</a>
            <a href="main_page.php#Stuff">Продукция</a>
            <a href="main_page.php#Vacancy">Вакансии</a>
            <a href="main_page.php#Contacts">Контакты</a>	
		</nav>
		<div class="icons">
        <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
            <div class="find-container">
                <div class="find-icon">
                    <ion-icon  name="search-outline"></ion-icon>
                </div>
                <div class="close" >
                    <ion-icon  name="close-circle-outline"></ion-icon>
                </div>
            </div>
			<div class="shop">
				<a href="#Cart">
					<ion-icon name="cart-outline"></ion-icon>
                    <span><?= $total_wishlist_counts; ?></span>
				</a>
			</div>
            <div class="wishlist">
                <a href="#">
                    <ion-icon name="heart"></ion-icon>
                    <span><?= $total_cart_counts; ?></span>
                </a>
                
            </div>
			
			<div class="person">
				<a><ion-icon name="people-circle-outline"></ion-icon></a>
			</div>
            <div class="menutoogle">
                <ion-icon name="menu-outline"></ion-icon>
			</div>
		</div>

        <div class="search-form">
			<input type="search" name="search-box" placeholder="Что ищем на этот раз?">
			<label for="search-box">
				<ion-icon name="search-outline"></ion-icon>
			</label>
		</div>
        <div class="login-form">
        <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <div class="user_container">
             <div class="box-icon">
             <ion-icon class="icon" name="person-circle-outline"></ion-icon>
             <p><?= $fetch_profile["name"]; ?></p>
             </div>
         <a class="update_data"><ion-icon name="create"></ion-icon>Редактировать профиль</a>
         <div class="flex-btn">
            <a class="signup"><ion-icon name="book"></ion-icon>Регистрация</a>
            <a class="signin" style="display:none;"><ion-icon name="log-in"></ion-icon>Логин</a>
         </div>
         <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Вы точно хотите выйти?');"><ion-icon name="log-out"></ion-icon>Выйти</a>
         </div>
         <?php
            }else{
         ?>
            <div class="log_container">
                <a class="signup"><ion-icon name="clipboard-outline"></ion-icon>Создать аккаунт</a>
                <a class="signin"><ion-icon name="log-in-outline"></ion-icon>Войти в аккаунт</a>
                <a class="update_data"  style="display:none;><ion-icon name="log-in-outline"></ion-icon>Войти в аккаунт</a>
            </div>  
            <?php
            }
            ?> 
        </div>
	</header>


    <div id="login-popup" class="login-popup">

    <div class="popup__body">
            
           
            <form action="" method="POST">
            <p class="login-popup__close">x</p>
            <img src="../images/logo5.png" alt="">
            <h3 class="heading">Вход в учетную запись</h3>
    
        <div class="user-box">
        <input type="text" name="email" maxlength="20"
        required   class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="mail"></ion-icon> Ваш E-mail</label>
        </div>
        <!-- /.user-box -->

        <div class="user-box">
        <input type="password" name="pass" maxlength="50"
        required class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="key"></ion-icon> Ваш пароль</label>
        </div>
        <!-- /.user-box -->
       

        <input type="submit" value="Войти" name="login" class="btn-login">
       </form>
    </div>
    <!-- /.popup__body -->

</div>
<!-- /.login-popup -->





<div id="update_user-popup" class="update_user-popup">

    <div class="popup__body">
        <form action="" method="POST">
            <p class="update_user-popup__close">x</p>
            <img src="../images/logo5.png" alt="">
            <h3 class="heading">Редактировать данные</h3>

            <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
    
            <div class="user-box">
        <input type="text" name="name" maxlength="20" class="box" 
        oninput="this.value = this.value.replace(/\s/g, '')" value="<?$fetch_profile['name'];?>">
        <label>Имя пользователя</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="email" name="email" maxlength="20" class="box" 
        oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>"">
        <label>Новая почта</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="old_pass" maxlength="50" class="box" 
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Старый пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="new_pass" maxlength="50" 
          class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Новый пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="cpass" maxlength="50"
          class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label>Подтвердите новый пароль</label>
        </div>
        <!-- /.user-box -->
       

        <input type="submit" value="Обновить" name="update" class="btn-login">
       </form>
    </div>
    <!-- /.popup__body -->

</div>
<!-- /.login-popup -->




<div id="register-popup" class="register-popup">

    <div class="popup__body">
            
           
            <form action="" method="POST">
            <p class="register-popup__close">x</p>
            <img src="../images/logo5.png" alt="">
            <h3 class="heading">Создать аккаунт учетной записи</h3>
    
        <div class="user-box">
        <input type="text" name="name" maxlength="20"
        required   class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="person-circle"></ion-icon> Имя пользователя</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="email" name="email" maxlength="50"
        required   class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="mail"></ion-icon> E-mail</label>
        </div>
        <!-- /.user-box -->

        <div class="user-box">
        <input type="password" name="pass" maxlength="50"
        required class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="key"></ion-icon> Придумайте пароль</label>
        </div>
        <!-- /.user-box -->
        <div class="user-box">
        <input type="password" name="cpass" maxlength="50"
        required class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">
        <label><ion-icon name="key"></ion-icon> Подтвердите пароль</label>
        </div>
        <!-- /.user-box -->
       

        <input type="submit" value="Создать аккаунт" name="registration" class="btn-login">
       </form>
    </div>
    <!-- /.popup__body -->

</div>
<!-- /.login-popup -->




















   