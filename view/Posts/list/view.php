<?php
/**
 * @var $result
 */
?>
<a href="/items/add/">Загрузить новую фотографию</a>
<?if (!empty($result['ITEMS'])) :?>
    <?foreach ($result["ITEMS"] as $itemKey => $itemValue) :?>
        <div id="post_<?=$itemValue['id']?>" style="border: 1px solid red;">
            <p>user: <?=$itemValue['username']?></p>
            <p>image: <img height='100' src="<?=$itemValue['image']?>"</p>
            <p>description: <?=$itemValue['description']?></p>
            <p>date: <?=$itemValue['date']?></p>
            <a href="/items/delete/<?=$itemValue['id']?>/">Удалить</a>
        </div>
    <?endforeach;?>
<?endif;?>
