<?php
/**
 * @var $result
 */
global $USER;
$userId = $USER->getId();
?>
<a href="/items/add/">Загрузить новую фотографию</a>
<?if (!empty($result['ITEMS'])) :?>
    <?foreach ($result["ITEMS"] as $itemKey => $itemValue) :?>
        <div id="post_<?=$itemValue['id']?>" style="border: 1px solid red;">
            <p>user: <?=$itemValue['username']?></p>
            <p>image: <img height='100' src="<?=$itemValue['image']?>"</p>
            <p>description: <?=$itemValue['description']?></p>
            <p>date: <?=$itemValue['date']?></p>
            <?foreach ($result['COMMENTARIES'][$itemValue['id']] as $commentary) :?>
                <p><?=$commentary['username']?>:<?=$commentary['commentary']?>
                <?if ($userId == $commentary['user_id']):?>
                    <a href="/items/<?=$itemValue['id']?>/commentary/<?=$commentary['id']?>/delete/">Удалить комментарий</a>
                <?endif;?>
                </p>
            <?endforeach;?>
            <form method="post" action="/items/<?=$itemValue['id']?>/commentaries/add/">
                <input type="text" name="commentary" value="">
                <input type="submit" name="submit_<?=$itemValue['id']?>" value="Отправить">
            </form>
            <?if ($userId == $itemValue['user_id']):?>
                <a href="/items/delete/<?=$itemValue['id']?>/">Удалить Пост</a>
            <?endif;?>
        </div>
    <?endforeach;?>
<?endif;?>
