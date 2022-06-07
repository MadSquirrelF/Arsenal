
<header class="header">
    
    <section class="flex">
        <div class="logo-flex">
            <img src="../images/settings.png" alt="">
            <a href="dashboard.php" class="logo">Панель<br> <span> Администратора</span></a>
        </div>
        <!-- /.logo-block -->
       

        <nav class="navbar">
            <a href="dashboard.php">Главная</a>
            <a href="products.php">Товар</a>
            <a href="placed_orders.php">Заказы</a>
            <a href="admin_accounts.php">Админы</a>
            <a href="users_accounts.php">Пользователи</a>
            <a href="messages.php">Сообщения</a>
        </nav>
        <div class="icons">
              
              <ion-icon  class="user-btn" name="people-outline"></ion-icon>
              <ion-icon class="menu-btn" name="menu-outline"></ion-icon>
        </div>
        <!-- /.icons -->
        <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ? ");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p><ion-icon name="person-circle-outline"></ion-icon><?=$fetch_profile['name']; ?></p>
        <a href="update_profile.php" class="btn"><ion-icon name="build-outline"></ion-icon>Редактировать профиль</a>
        <div class="flex-btn">
            <a href="admin_login.php" class="option-btn"><ion-icon name="enter-outline"></ion-icon>Войти</a>
            <a href="register_admin.php" class="option-btn"><ion-icon name="create-outline"></ion-icon>Создать</a>
        </div>
        <!-- /.flex-btn -->
        <a href="../components/admin_logout.php" 
        onclick="return confirm ('Вы действительно хотите выйти?'); " class="delete-btn"><ion-icon name="log-out-outline"></ion-icon>Выйти</a>
        </div>
        <!-- /.profile -->

    </section>
</header>