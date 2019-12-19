<?php
    require "db.php";

    $data = $_POST;
    if (isset($data['do_singup']))
    {
        $errors = array();
        
        /* если заполнить все поля не регается => не создается бд */
        /* регулярка вообще зло */
        

        /* Логин должен содержать не менее 4 символов, русские или английские
            символы, цифры, знак подчеркивания, не допускаются 4 подряд идущих
            одинаковых символа. */
        if (trim($data['login']) == '' || strlen($data['login']) < 4 || $data['login'] != preg_match("/[0-9а-яёА-ЯЁa-zA-z]{4}/ui"))
        {
            $errors[] = 'Write login or your login is shot (min:4)!<br>';
            $errors[] = 'or your login consists of 4 the same symbols!';
        }


        if(trim($data['phone']) == '' || trim($data['phone']) != preg_match("/375[0-9]{9}/u"))
        {
            $errors = 'Write phone OR phone number was written with an error';
        }

        /* Email должен не допускается использовать почту содержащую в имени
            нецензурные слова и выражения. */
        if (trim($data['email']) == '' )
        {
            $errors[] = 'Write Email!';
        }
       
        /* Пароль должен состоять не менее, чем из 10 символов и не должен
            содержать слова (козел, баран, олух) в русской и латинской транскрипции. */
        if ($data['password'] == '' || preg_match("/(козел)(баран)(олух)(kozel)(baran)(oluh)/", $data['password']));
        {
            $errors[] = 'Write password! <br>';
            $errors = 'Or you used bad word!';
        }
       

        if ($data['password_2'] != $data['password'])
        {
            $errors[] = 'Second password wasn-t right!';
        }

        if (R::count('users', "login = ?", array($data['login'])) > 0)
        {
            $errors[] = 'This login is-t free!';
        }







        /* бд */
        if (empty($errors))
        {
            $user = R::dispense('users');
            $user->login  = $data['login'];
            $user->email  = $data['email'];
            $user->phone  = $data['phone'];
            $user->sex  = $data['sex'];
            $user->password  = password_hash($data['password'], PASSWORD_DEFAULT);
            R::store($user);
            echo '<div style="color: green;">Well done</div><hr>';
            /* запись в файл, что все ок */
        }else
        {
            echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
            /* запись в файл, что не вышло */
        }

    }
?>

<form action="singup.php" method="POST">
    <p>
        <p><strong>Login</strong>:</p>
        <input type="text" name="login" value="<?php echo @$data['login']; ?>">
    </p>
    <p>
        <p><strong>Email</strong>:</p>
        <input type="email" name="email"  value="<?php echo @$data['email']; ?>">
    </p>
    <p>
        <p><strong>Phone</strong>:</p>
        <input type="number" name="phone"  value="<?php echo @$data['phone']; ?>">
    </p>
    <p>
        <p><strong>Sex</strong>:</p>
        <input name="sex" type="radio" value="M" checked>
            <b>M</b> <br>
        <input name="sex" type="radio" value="F" checked>
            <b>F</b> <br>
    </p>
    <p>
        <p><strong>Password</strong>:</p>
        <input type="password" name="password" >
    </p>
    <p>
        <p><strong>Passport one more time</strong>:</p>
        <input type="password" name="password_2"  value="<?php echo @$data['password_2']; ?>">
    </p>
    <p>
        <button type="submit" name="do_singup">Submit</button>
    </p>
</form>