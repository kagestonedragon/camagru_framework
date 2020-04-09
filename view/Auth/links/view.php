<?global $USER?>
<?if (!empty($USER->getId())) :?>
    <p><?=$USER->getUsername()?> | <a href="/logout/">Выйти</a></p>
<?else:?>
    <p><a href="/auth/">Войти</a> | <a href="/registration/">Регистрация</a></p>
<?endif;?>
