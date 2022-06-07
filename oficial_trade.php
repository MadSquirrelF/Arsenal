<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOO Арсенал - Ремонт промышленного оборудования</title>
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon" href="img/54.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Playfair+Display+SC:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:ital,wght@0,400;0,500;1,700&family=Roboto:ital,wght@0,400;0,700;1,100;1,900&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'?>

<section class="learn_more">
    <div class="row" style="background-image: url(img/bg_oficial_trade.png);">
        <div class="block">
        <h1>ОФИЦИАЛЬНЫЙ ПОСТАВЩИК</h1>
        <div class="nav"><a href="main_page.php">Главная</a> <ion-icon name="chevron-forward-outline"></ion-icon> <span>Официальный поставщик</ы></div>
        </div>
        
    </div>
    <!-- /.row -->
    
    <div class="content__container">
       
       <div class="content left">
       <img src="img/titlepic_oficial_trade.png" alt="">
       <h1>Заголовок 1</h1>
       </div>
       <!-- /.content__1 -->
       <p style="text-align:left;">Следует отметить, что консультация с широким активом требует определения и уточнения системы обучения кадров, соответствующей насущным потребностям. Также как убеждённость некоторых оппонентов, а также свежий взгляд на привычные вещи — безусловно открывает новые горизонты для глубокомысленных рассуждений. Значимость этих проблем настолько очевидна, что реализация намеченных плановых заданий говорит о возможностях модели развития.</p>
       <div class="content right">
       <h1>Заголовок 2</h1>
       <img src="img/title2_oficial_trade.png" alt="">
       </div>
       <!-- /.content__2 -->
       <p style="text-align:right;">Таким образом, убеждённость некоторых оппонентов, а также свежий взгляд на привычные вещи — безусловно открывает новые горизонты для прогресса профессионального сообщества. Принимая во внимание показатели успешности, начало повседневной работы по формированию позиции создаёт предпосылки для поставленных обществом задач. Следует отметить, что новая модель организационной деятельности предопределяет высокую востребованность первоочередных требований.</p>
       
    </div>
    <!-- /.content__container -->
</section>
<!-- /.learn_more -->
<?php include 'components/footer.php'?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://kit.fontawesome.com/558b50b95a.js" crossorigin="anonymous"></script>
</body>
</html>