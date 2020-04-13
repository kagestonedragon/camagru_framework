<?php
/**
 * @var $result
 */
global $USER;
$userId = $USER->getId();
$username = $USER->getUsername();
//\Framework\Modules\Debugger::show($result['COMMENTARIES']);
?>
<a href="/items/add/">Загрузить новую фотографию</a>
<?if (!empty($result['ITEMS'])) :?>
    <!-- COMMENT TEMPLATE -->
    <div class="posts__comments__item js-comment-template" style="display: none;">
        <a class="posts__comments__item-author" href="#">
            @<?=$username?>
        </a>
        <span class="posts__comments__item-delimiter">:</span>
        <span class="posts__comments__item-text"></span>
        <a href="/items/#item_id#/commentary/#comment_id#/delete/" class="posts__comments__item-delete js-comment-delete">
            <i class="fas fa-times"></i>
        </a>
    </div>
    <!-- END COMMENT TEMPLATE -->
    <?foreach ($result['ITEMS'] as $itemKey => $itemValue) :?>
        <?$date = DateTime::createFromFormat('Y-m-d H:i:s', $itemValue['date']);?>
        <?$itemValue['date'] = $date->format('d.m.Y');?>
        <article class="content">
            <div class="posts">
                <div class="posts__image">
                    <img src="<?=$itemValue['image']?>">
                </div>
                <div class="posts__info">
                    <div class="posts__info-author">
                        <a class="posts__info-author__name" href="#">
                            @<?=$itemValue['username']?>
                        </a>
                        <span class="posts__info-author__delimiter">|</span>
                        <span class="posts__info-author__date">
                            <?=$itemValue['date']?>
                        </span>
                    </div>
                    <div class="posts__info-likes js-likes">
                        <span class="posts__info-likes__amount js-likes-amount">
                            <?=$itemValue['likes']?>
                        </span>
                        <?if ($itemValue['LIKE_ACTION'] == 'add') :?>
                            <a href="/items/<?=$itemValue['id']?>/likes/add/" class="posts__info-likes__like js-likes-add">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="/items/<?=$itemValue['id']?>/likes/delete/" class="posts__info-likes__unlike js-likes-delete" style="display: none;">
                                <i class="fas fa-heart"></i>
                            </a>
                        <?elseif ($itemValue['LIKE_ACTION'] == 'delete') :?>
                            <a href="/items/<?=$itemValue['id']?>/likes/add/" class="posts__info-likes__like js-likes-add" style="display: none;">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="/items/<?=$itemValue['id']?>/likes/delete/" class="posts__info-likes__unlike js-likes-delete">
                                <i class="fas fa-heart"></i>
                            </a>
                        <?endif;?>
                    </div>
                </div>
                <div class="posts__description">
                    <?=$itemValue['description']?>
                </div>
                <hr class="posts__delimiter">
                <?if (!empty($result['COMMENTARIES'])) :?>
                    <div class="posts__comments">
                        <?foreach ($result['COMMENTARIES'][$itemValue['id']] as $commentary) :?>
                            <div class="posts__comments__item js-comment">
                                <a class="posts__comments__item-author" href="#">
                                    @<?=$commentary['username']?>
                                </a>
                                <span class="posts__comments__item-delimiter">:</span>
                                <span class="posts__comments__item-text"><?=$commentary['commentary']?></span>
                                <?if ($userId == $commentary['user_id']) :?>
                                    <a href="/items/<?=$itemValue['id']?>/commentary/<?=$commentary['id']?>/delete/" class="posts__comments__item-delete js-comment-delete">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?endif;?>
                            </div>
                        <?endforeach;?>
                    </div>
                <?endif;?>
                <div class="posts__comments-new js-comments js-new-comment">
                    <form class='js-new-comment-form' method="post" action="/ajax/items/<?=$itemValue['id']?>/commentaries/add/">
                        <input class="posts__comments-new__text js-new-comment-text" type="text" name="commentary" value="" placeholder="Оставьте комментарий">
                        <div class="posts__comments-new__submit js-new-comment-button">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <input class="js-new-comment-submit" type="submit" name="submit" style="display: none;">
                    </form>
                </div>
            </div>
        </article>
    <?endforeach;?>
<?endif;?>