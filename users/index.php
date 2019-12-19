<?php
    require "db.php";
?>

<?php  if( isset($_SESSION['logged_user']) ) : ?>
        Login done
        <hr>
        <a href="logout.php">Out</a>
        <!-- //ссылки на пару лаб, фио -->
<?php else : ?> 
    <a href="login.php">Авторизация</a>
    <a href="singup.php">Регистрация</a>
<?php endif; ?> 