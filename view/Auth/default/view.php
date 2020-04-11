<?php
/**
 * @var $result
 */
use Framework\Models\Auth\Authorize;
?>
<?if (isset($result['status'])) :?>
    <?if ($result['status'] == Authorize::STATUS['NOT_VALID_DATA']) :?>
        <p>Не верные данные!</p>
    <?elseif ($result['status'] == Authorize::STATUS['NOT_VERIFIED']) :?>
        <p>Аккаунт не подтвержден!</p>
    <?endif;?>
<?endif;?>
<form method="post">
    <label>
        username: <input type="text" name="username" value="">
    </label>
    <br>
    <label>
        password: <input type="password" name="password" value="">
    </label>
    <br>
    <input type="submit" name="submit" value="Отправить">
</form>