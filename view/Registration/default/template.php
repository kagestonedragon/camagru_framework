<?php
use Framework\Modules\Localization as Loc;

Loc::init(__FILE__);
?>
<form method="post">
    <label>
        <?=Loc::getMessage('TITLE_USERNAME')?>: <input type="text" name="username" value="">
    </label>
    <br>
    <label>
        <?=Loc::getMessage('TITLE_EMAIL')?>: <input type="email" name="email" value="">
    </label>
    <br>
    <label>
        <?=Loc::getMessage('TITLE_PASSWORD')?>: <input type="password" name="password" value="">
    </label>
    <br>
    <input type="submit" name="submit" value="<?=Loc::getMessage('TITLE_SUBMIT')?>">
</form>