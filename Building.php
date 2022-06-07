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
    <title>OOO Арсенал - Строительные работы</title>
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
    <div class="row" style="background-image: url(img/Building_bg.png);">
        <div class="block">
        <h1>СТРОИТЕЛЬНЫЕ РАБОТЫ</h1>
        <div class="nav"><a href="main_page.php">Главная</a> <ion-icon name="chevron-forward-outline"></ion-icon> <span>Строительные работы</ы></div>
        </div>
        
    </div>
    <!-- /.row -->
    
    <div class="content__container">
       
       <div class="content left">
       <img src="img/BuildTitle1.jpeg" alt="">
       <h1>Широкий спектр</h1>
       </div>
       <!-- /.content__1 -->
       <p style="text-align:left;">Широкий спектр общестроительных работ начинается с проектных, геодезических и подготовительных работ для тщательной проработки задачи поставленной «Заказчиком» строительства. Земляные работы включающие в себя нулевой цикл, вертикальную планировку, погрузочно-разгрузочные работы, перевозку грунта и т.п. подготавливают участок к будущему строительству. ООО «Арсенал» выполняет данные работы собственными силами, и при необходимости, при сложных условиях привлекает наёмную тяжелую и специализированную технику.</p>
       <div class="content right">
       <h1>Устройство фундаментов</h1>
       <img src="img/BuildTitle2.jpeg" alt="">
       </div>
       <!-- /.content__2 -->
       <p style="text-align:right;">Устройство фундаментов любой сложности ленточные, стаканные, столбчатые, свайные и плитные фундаменты также сборные, монолитные и монолитно-сборные в зависимости от назначения и архитектурных решений создаёт основу здания, на которую впоследствии опираются все вышележащие конструкции.</p>
       <div class="content left">
       <img src="img/BuildTitle3.jpeg" alt="">
       <h1>Кладка</h1>
       </div>
       <!-- /.content__1 -->
       <p style="text-align:left;">Работы включают в себя устройство арматурного каркаса, сборку опалубки, приемку бетона, уход за конструкцией, изоляцию и др. На каждом этапе проведения работ выполняется многоуровневый контроль качества. Кладка стен из кирпича, блоков и камня, монтаж конструкционных элементов, а также отделочные работы выполняемые с целью придать зданию защитные и декоративные свойства относятся к общестроительным работам успешно выполняемых специалистами ООО «Арсенал»</p>
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