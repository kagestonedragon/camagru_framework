<?php
/**
 * @var $result
 */

use Framework\Models\Registration\Verificate;
use Framework\Models\Registration\Register;
?>
<?if ($result['status'] == Register::STATUS['SUCCESS']) :?>
    <p>На почтовый адрес <?=$result['email']?> была отправлена ссылка для подтверждения регистрации</p>
<?elseif ($result['status'] == Verificate::STATUS['VERIFICATION']) :?>
    <p>Почтовый адрес успешно подтвержен! Можете авторизоваться на сайте!</p>
<?elseif ($result['status'] == Verificate::STATUS['ALREADY_VERIFIED']) :?>
    <p>Ваш аккаунт уже подтвержден! Может авторизоваться на сайте!</p>
<?elseif ($result['status'] == Verificate::STATUS['NOT_VALID_TOKEN']) :?>
    <p>Невалидный токет! Проверьте письмо!</p>
<?endif;?>
