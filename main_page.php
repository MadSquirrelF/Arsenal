<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

 if(isset($_POST['subscribe'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `subscribe` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'Пользователь с такой почтой уже подписан!';
    }else{
          $insert_email = $conn->prepare("INSERT INTO `subscribe`(user_id, email) VALUES(?,?)");
          $insert_email->execute([$user_id, $email]);

          $message[] = 'Вы успешно подписались на новости!';
    }
    
};
if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
 
    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND number = ? AND message = ?");
    $select_message->execute([$name,$number, $msg]);
 
    if($select_message->rowCount() > 0){
       $message[] = 'already sent message!';
    }else{
 
       $insert_message = $conn->prepare("INSERT INTO `messages`(user_id,name,number,message) VALUES(?,?,?,?)");
       $insert_message->execute([$user_id, $name,$number, $msg]);
 
       $message[] = 'sent message successfully!';
 
    }
 
};

include 'components/wishlist_cart.php';

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
<section class="Home" id="Home" style="background-image: url(img/Background.png) ;">

    
        <div class="row">
       
            <div class="content">
                <h1>Ремонтируем и производим промышленное оборудование более 15 лет</h1>
                <div class="header_content-container">
                    <div class="stuff">
                        <a href="#" class="btn"><span></span>Продукция</a>
                    </div>
                    <div class="header__contacts">
                        <a href="#" class="header__contacts-item">
                            <ion-icon name="compass-outline"></ion-icon>
                            <span> Ул. Героев Танкограда, 51П, пом. 5.</span>
                        </a>
                        <a href="tel:+73512395333" class="header__contacts-item">
                            <ion-icon name="call-outline"></ion-icon>
                            <span>+7 (351) 239 -53 -33/34<br>
                                +7 (351) 222 -44 -60/61</span>
                        </a>
                    </div>
                </div>
                <!-- /.header_content-container -->
            </div>
            <!-- /.content -->
            <div class="header_mouse-effect">
                <img src="img/mouse.svg" class="header_mouse-effect-mouse" alt="">
            </div>
        </div>
        <!-- /.row -->
    </section>
    <section class="banner" id="banner">
        <div class="row">
            <div class="section__number">
                I
            </div>
            <div class="box-container">
                <a href="oficial_trade.php" class="box">
                    <img src="img/House.svg">
                    <p>Официальный
                        поставщик</p>
                </a>
                <a href="http://optlbelt.ru/" class="box">
                    <img src="img/belt.svg">
                    <p>Приводные
                        ремни
                       </p>
                </a>
                <a href="http://tdmtz.su/" class="box">
                    <img src="img/tractor.svg">
                    <p>Спецтехника</p>
                </a>
                <a href="#Engineer" class="box">
                    <img src="img/work.svg">
                    <p>Услуги
                        по ремонту </p>
                </a>
            </div>
            <!-- /.box-container -->
        </div>
        <!-- /.row -->
    </section>
    <section class="About" id="About">
        <div class="name__section">
            <h1 class="heading">О нашей компании</h1>
            <span>II</span>
        </div>
        <h3>ООО «АРСЕНАЛ» г. Челябинск 
        </h3>
        <div class="row">
            <div class="about__container" style="background-image: url(img/back2.png) ">
                <div class="text">
                    <p>Надежный партнер и поставщик только высококачественной 
                        продукции производственно-технического назначения.</p>
                </div>
                <img src="img/Logo.svg">
            </div>
            <!-- /.about__container -->
            <div class="second__line">
                <h2>Мы предлагаем вам комплексное техническое обслуживание промышленного оборудования, 
                    а также промышленных зданий и сооружений. </h2>
                    <div class="number__container">
                        <ion-icon name="phone-portrait-outline"></ion-icon>
                        <h1>+ 7 (800) 100 06 20</h1>
                    </div>
                    <!-- /.number__container -->
            </div>
            <!-- /.second__line -->
            <div class="third__line">
                <img src="img/about_pic.png">
               <p>Поставляемые нами комплектующие помогут сократить затраты на ремонт и обслуживание оборудования, увеличить эффективность производства, что, в конечном итоге, положительно отразится на себестоимости вашей продукции.</p>
            </div>
            <div class="fourth_line">
                <div class="box">
                    <div class="number__banner">
                       <ion-icon name="shield-checkmark-outline"></ion-icon>
                        <h1>01</h1>
                        
                    </div>
                    <h2>ОФИЦИАЛЬНЫЙ ДИЛЛЕР</h2> 
                    <p>Предлагаем широкий уровень
                       ассортимента в любой ценовой
                       категории </p>
                </div>
                <div class="box">
                   <div class="number__banner">
                       <ion-icon name="shield-checkmark-outline"></ion-icon>
                       <h1>02</h1>
                      
                   </div>
                   <h2>ДОСТУПНЫЕ ЦЕНЫ</h2> 
                   <p>Предоставляем самые доступные цены 
                       от завода-производителя</p>
               </div>
               <div class="box">
                   <div class="number__banner">
                       <ion-icon name="shield-checkmark-outline"></ion-icon>
                       <h1>03</h1>
                       
                   </div>
                   <h2>ПОДДЕРЖКА</h2> 
                   <p>Мы заботимся о наших клиентах,
                       покупателях , пользователях на всех 
                      этапах сделки</p>
    
               </div>
            </div>
            <!-- /.fourth_line -->
        </div>
        <!-- /.row -->
        

    </section>
    <section class="Engineer" id="Engineer">
        <div class="name__section-left">
            <h1 class="heading">Инженерный центр</h1>
            <span>III</span>
        </div>

        <div class="container">
            <div class="accordion">
                <div class="accordion-item" id="question1">
                    <hr>
                    <a class="accordion-link" href="#question1">
                        <div class="flex">
                            <h3>СТРОИТЕЛЬНЫЕ РАБОТЫ</h3>
                            <ul>

                              <li>#Ремонт</li>
                              <li>#Строительство</li>
                              <li>#Реконструкция</li>
                              <li>#Ремонт</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/build2.jpeg">
                        <p>
                          ООО «Арсенал» выполняет полный комплекс общестроительных работ по промышленному и гражданскому строительству, возводя объекты как с «нуля» так и проводя реконструкцию уже существующих. 
                        </p>
                        <a href="Building.php">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question2">
                    <a class="accordion-link" href="#question2">
                        <div class="flex">
                            <h3>ПЕРЕЗАЛИВКА БАББИТОМ</h3>
                            <ul>
                             
                              <li>#Ремонт</li>
                              <li>#Строительство</li>
                              <li>#Реконструкция</li>
                              <li>#Ремонт</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/Number1.jpg">
                        <p>
                            Технологический процесс заливки состоит из подготовки форм, плавки баббита и заливки форм. Подшипники, подлежащие заливке, обезжиривают и протирают насухо. 
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question3">
                    <a class="accordion-link" href="#question3">
                        <div class="flex">
                            <h3>РЕМОНТ МЕЛЬНИЦ</h3>
                            <ul>
                              <li>#Трапециевидные</li>
                             
                              <li>#Мельницы</li>
                              <li>#Шаровые</li>
                              <li>#Молотковые</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/Ремонт_шаровых_мельниц.jpeg">
                        <p>
                            Перед остановкой размольной шахтной мельницы для ремонта производят наружный осмотр ее и выявляют все види­мые дефекты.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question4">
                    <a class="accordion-link" href="#question4">
                        <div class="flex">
                            <h3>РЕМОНТ КРАНОВ</h3>
                            <ul>
                              <li>#Козловые</li>
                              <li>#Ремонт</li>
                              <li>#Краны</li>
                              <li>#Мостовые</li>
                              <li>#Башенные</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image13.jpeg">
                        <p>
                            Наша компания производит ремонт, обслуживание, монтаж и демонтаж грузоподъемных (мостовых, козловых, портовых, железнодорожных, автомобильных, специальных и других) кранов, подкрановых путей, кран-балок, грейферов.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question5">
                    <a class="accordion-link" href="#question5">
                        <div class="flex">
                            <h3>ЦЕНТРОВКА ВАЛОВ</h3>
                            <ul>
                              <li>#Arsenal</li>
                              <li>#Ремонт</li>
                              <li>#Центровка</li>
                              <li>#Вал</li>
                              <li>#Оборудоване</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image1.jpeg">
                        <p>
                            Центровка валов электродвигателей и соединенных с ним рабочих машин непосредственно влияет на техническое состояние как электродвигателей, так и самих машин. Параллельное смещение осей валов электродвигателей и рабочих машин вызывает деформацию упругих элементов соединительных муфт, пульсацию передаваемых моментов, а также радиальные усилия, передаваемые на подшипники. Угловое смещение осей валов вызывает значительно меньшие пульсации скорости валов, чем их параллельное смещение.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question6">
                    <a class="accordion-link" href="#question6">
                        <div class="flex">
                            <h3>РЕМОНТ ГАЗОДУВОК</h3>
                            <ul>
                              <li>#Arsenal</li>
                              <li>#Ремонт</li>
                              <li>#воздуходувок</li>
                              <li>#дымососов</li>
                              <li>#вентиляторов</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image6.jpg">
                        <p>
                            Все установки отличаются высокой производительностью и могут работать в круглосуточном режиме, но, как и вся техника, иногда останавливаются для проведения профилактического или капитального ремонта.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question7">
                    <a class="accordion-link" href="#question7">
                        <div class="flex">
                            <h3>СВАРОЧНЫЕ РАБОТЫ</h3>
                            <ul>
                              <li>#Arsenal</li>
                              <li>#Сварка</li>
                              <li>#Гарантия</li>
                              <li>#Профиль</li>
                              <li>#Качество</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image7.png">
                        <p>
                        Еще одной услугой, предоставляемой нашей компанией, являются сварочные работы на строящихся и уже эксплуатируемых объектах. На практике знакомые с передовыми технологиями дипломированные сварщики, аттестованные в НАКС
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question8">
                    <a class="accordion-link" href="#question8">
                        <div class="flex">
                            <h3>РЕМОНТ ГАЗОСНАБЖЕНИЯ</h3>
                            <ul>
                              <li>#Монтаж</li>
                              <li>#Демонтаж</li>
                              <li>#Водо-</li>
                              <li>#Тепло-</li>
                              <li>#Снабжения</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image8.png">
                        <p>
                         Монтаж, ремонт, настройка сетей и оборудования газоснабжения.Монтаж- демонтаж внутриквартальных сетей тепло-вода снабжения и многое по ссылке в описании.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question9">
                    <a class="accordion-link" href="#question9">
                        <div class="flex">
                            <h3>РЕМОНТ ПРИЦЕПОВ</h3>
                            <ul>
                              <li>#Пневмо-подвески</li>
                              <li>#Рамы</li>
                              <li>#Полы</li>
                              <li>#Борты</li>
                              <li>#Стойки</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image9.png">
                        <p>
                        Капитальный ремонт прицепов и полуприцепов Российских и иностранных производителей.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question10">
                    <a class="accordion-link" href="#question10">
                        <div class="flex">
                            <h3>РЕМОНТ ЛИНИЙ ЭЛЕКТРОСНАБЖЕНИЯ</h3>
                            <ul>
                              <li>#СИП</li>
                              <li>#Монтаж</li>
                              <li>#Демонтаж</li>
                              <li>#Высоковольтные</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image10.png">
                        <p>
                          Монтаж, демонтаж и ремонт линий электроснабжения 0,4; 6;10,35 кВт.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question11">
                    <a class="accordion-link" href="#question11">
                        <div class="flex">
                            <h3>МОНТАЖ ТРУБОПРОВОДОВ</h3>
                            <ul>
                              <li>#ХВС</li>
                              <li>#ГВС</li>
                              <li>#Канализации</li>
                              <li>#Отопления</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image11.png">
                        <p>
                        Наша компания занимается монтажом технологических трубопроводов, водопроводов ХВС и ГВС, канализации и отопления под ключ в
                        производственных цехах и сооружениях, в жилых и иного назначения зданиях. За годы работы в сфере монтажа инженерных систем, нашими специалистами реализованы сотни проектов, сложность исполнения многих из которых достойна учебников по строительному делу.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question12">
                    <a class="accordion-link" href="#question12">
                        <div class="flex">
                            <h3>МОНТАЖ НАСОСОВ</h3>
                            <ul>
                              <li>#Все типы</li>
                              <li>#Ремонт</li>
                              <li>#Подбор</li>
                              <li>#Вихревые</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image12.png">
                        <p>
                        Ремонт и монтаж насосов: 
                         Центробежных,
                        Поршневых, Мембранных,
                        Шиберных(пластинчатых),
                         Вихревых, Винтовых и 
                        Струйных разных марок.
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
                <div class="accordion-item" id="question13">
                    <a class="accordion-link" href="#question13">
                        <div class="flex">
                            <h3>МОНТАЖ НАСОСНОГО ОБОРУДОВАНИЯ</h3>
                            <ul>
                              <li>#скважинные</li>
                              <li>#колодезные</li>
                              <li>#водопроводные</li>
                              <li>#циркуляционные</li>
                            </ul>
                        </div>
                        <i class="icon ion-md-arrow-forward"></i>
                        <i class="icon ion-md-arrow-down"></i>
                    </a>
                    <div class="answer">
                        <img src="img/image14.jpeg">
                        <p>
                      
Одним из направлений деятельности нашей компании является замена, установка, капитальный ремонт водяных насосов всех типов:
поверхностные,повысительные, циркуляционные, погружные, полупогружные и т.д..<br>Специалисты компании прошедшие обучение и аттестацию в специализированных центрах, с большим стажем работы в кратчайшие сроки произведут монтаж, демонтаж и установку следующего насосного оборудования...
                        </p>
                        <a href="#">Смотреть пример</a>
                    </div>
                    <hr>
                    <!-- /.answer -->
                </div>
                <!-- /.accordion-item -->
            </div>
            <!-- /.accordion -->
        </div>
        <!-- /.container -->
    </section>
    <section class="Stuff" id="Stuff">
        <div class="name__section-left">
            <h1 class="heading">Каталог продукции</h1>
            <span>IV</span>
        </div>
        <div class="wrapper">
            <a href="#" class="box" style="background-image: url(img/cat1.png);">
                <h1>Подшипники</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat7.png);">
                <h1>Редукторы Nord</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat6.png);">
                <h1>Уплотнения Simrit</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat4.png);">
                <h1>Защита от влаги и коррозии</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat5.png);">
                <h1>Шкивы Optibelt</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat2.png);">
                <h1>Спецтехника (Сельхозтехника)</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat3.png);">
                <h1>Shell: масла и смазки</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat12.png);">
                <h1>Запчасти на дробилки</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat9.png);">
                <h1>Weicon клеи и герметики</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat0.jpg);">
                <h1>Конвейерное оборудование</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat11.png);">
                <h1>Конвейерные ленты ПВХ,ПУ</h1></a>
              <a href="#" class="box" style="background-image: url(img/cat8.png);">
                <h1>Приводные ремни</h1></a>
        </div>
        <!-- /.wrapper -->
    </section>
    <section class="Vacancy" id="Vacancy">
        <div class="name__section-left">
            <h1 class="heading">Недавние вакансии</h1>
            <span>V</span>
        </div>
        <div class="row">
            <div class="cart-container">
                <div class="cart">
                    <div class="front" style="background-image: url(img/vac1.png) ;">
                        <h1>ИНЖЕНЕР ПТО</h1>
                    </div>
                    <div class="back">
                        <h1>ИНЖЕНЕР ПТО</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                        Высшее техническое образование.<br>Работа с проектно-сметной документацией, техническое сопровождение проектов, оформление исполнительной документации, технический надзор, согласование проектов</h2>
                        <p>Условия:<br>
                        Трудоустройство в соответствии с ТК РФ. Командировки по Челябинской области.
                        Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                        Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
                <div class="cart">
                    <div class="front" style="background-image: url(img/vac2.png) ;">
                        <h1>Инженер-конструктор</h1>
                    </div>
                    <div class="back">
                        <h1>Инженер-конструктор</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                             Высшее техническое образование.<br>Знание ЕСКД, навык работы в конструкторских программах</h2>
                        <p>Условия:<br>
                            Трудоустройство в соответствии с ТК РФ.
                             Командировки по Челябинской области.
                            Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                            Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
                <div class="cart">
                    <div class="front" style="background-image: url(img/vac3.png) ;">
                        <h1>Электрогазосварщик</h1>
                    </div>
                    <div class="back">
                        <h1>Электрогазосварщик</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                        Профильное образование.<br>Наличие квалификационного удостоверения</h2>
                        <p>Условия:<br>
                            Трудоустройство в соответствии с ТК РФ.
                             Командировки по Челябинской области.
                            Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                            Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
                <div class="cart">
                    <div class="front x4" style="background-image: url(img/vac4.png) ;">
                        <h1>Монтажник по монтажу стальных и железобетонных конструкций</h1>
                    </div>
                    <div class="back">
                        <h1>Монтажник конструкций</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                                Профильное образование.<br>Монтаж технологического оборудования и металлоконструкций на строительном объекте, в том числе на промышленных предприятиях области</h2>
                        <p>Условия:<br>
                            Трудоустройство в соответствии с ТК РФ.
                             Командировки по Челябинской области.
                            Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                            Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
                <div class="cart">
                    <div class="front" style="background-image: url(img/vac5.png) ;">
                        <h1>Слесарь-ремонтник промышленного оборудования</h1>
                    </div>
                    <div class="back">
                        <h1>Слесарь-ремонтник</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                             Профильное образование.<br>Выполнение работ по ремонту оборудования, в том числе на промышленных предприятиях области</h2>
                        <p>Условия:<br>
                            Трудоустройство в соответствии с ТК РФ.
                             Командировки по Челябинской области.
                            Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                            Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
                <div class="cart">
                    <div class="front" style="background-image: url(img/vac6.png) ;">
                        <h1>Главный энергетик</h1>
                    </div>
                    <div class="back">
                        <h1>Главный энергетик</h1>
                        <div class="sl">
                            <p>График 5/2</p>
                            <p>Опыт работы</p>
                        </div>
                        <h2>Требования:<br>
                        Профильное образование.<br>Организация технически правильной эксплуатации и своевременного ремонта энергетического оборудования и энергосистем</h2>
                        <p>Условия:<br>
                            Трудоустройство в соответствии с ТК РФ.
                             Командировки по Челябинской области.
                            Оплата расходов на транспорт, сотовую связь, командировочных, жилья.
                            Полный соцпакет.
                        </p>
                        <p>Заработная плата назначается по результатам собеседования</p>
                        <div class="leftVac">
                            <a href="#" class="btn">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <!-- /.cart -->
            </div>
            <!-- /.cart-container -->
        </div>
        <!-- /.row -->
    </section>
    <section class="InputBanner" id="InputBanner"  style="background-image: url(img/bacbanner.png)">
        <div class="row">
            <div class="container__left">
                <h1>Что-то уже выбрали?</h1>
                <h3>Передайте нам ваши данные и мы свяжемся с вами для консультации в ближайшее время.</h3>
                
            </div>
            <!-- /.container__left -->
            <div class="container__right">
                <form action="" method="POST">
                    <div class="form">
                        <div class="from__item">
                         <input class="inp" type="text" name="name" placeholder="Ваше имя" required maxlength="20">
                        </div>
                        <div class="from__item">
                        <input class="inp" type="number" name="number" min="0" max="99999999999" placeholder="Ваш номер телефона" required onkeypress="if(this.value.length == 11) return false;" >
                        </div>
                        <div class="from__item">
                        <textarea class="inp" name="msg" placeholder="Ваше сообщение" cols="30" rows="1"></textarea>
                        </div>
                        <div class="from__item">
                         <input type="submit"  value="Отправить письмо" name="send" class="btn-accept">
                        </div> 
                    </div>
                </form>
            </div>
            <!-- /.container__right -->
            
        </div>
        <!-- /.row -->
    </section>
    <section class="Contacts" id="Contacts">
        <div class="name__section-left">
            <h1 class="heading">Район на карте</h1>
            <span>VI</span>
        </div>
        <div class="row">
            <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1298.1827345687375!2d61.4415445418163!3d55.21360181899088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43c5ec503c81161f%3A0x8c44e034810c660!2z0YPQuy4g0JPQtdGA0L7QtdCyINCi0LDQvdC60L7Qs9GA0LDQtNCwLCA1MdCfLCDQp9C10LvRj9Cx0LjQvdGB0LosINCn0LXQu9GP0LHQuNC90YHQutCw0Y8g0L7QsdC7LiwgNDU0MDAw!5e1!3m2!1sru!2sru!4v1652566446725!5m2!1sru!2sru"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <!-- /.row -->
       
    </section>
    <section class="newsletter">
        
		<div class="content">
			<h1>Желаете подписаться?</h1>
            <p>*Мы никому не передаем ваши данные.<br>
                И не сохраняем вашу почту для спама.</p>
		</div>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Ваш E-mail" required maxlength="50" class="email">
            <input type="submit" value="Подписаться" name="subscribe" class="btn">
        </form>
           
            
        
		<img class="top" src="img/top.png" alt="">
        <img class="down" src="img/subscribepic.png" alt="">
	</section>
    <?php include 'components/footer.php'; ?>







  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://kit.fontawesome.com/558b50b95a.js" crossorigin="anonymous"></script>
</body>
</html>