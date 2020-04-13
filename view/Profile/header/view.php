<?
global $USER;
?>
<nav class="nav">
    <div class="nav__item-logo">
        <a href="/">Camagru</a>
    </div>
    <div class="nav__item-menu">
        <a href="/profile/<?=$USER->getUsername()?>/"><?=$USER->getUsername()?></a>
        <span class="nav__item-delimiter">|</span>
        <a href="/logout/">Выйти</a>
    </div>
    <div class="nav-mobile">
        <i class="fas fa-bars nav-mobile__item" id="js-menu-open"></i>
        <i class="fas fa-times nav-mobile__item" id="js-menu-close" style="display: none;"></i>
    </div>
</nav>
<div class="nav-mobile__menu-closed" id="js-menu-fields">
    <a href="/profile/<?=$USER->getUsername()?>/"><?=$USER->getUsername()?></a>
    <a href="/logout/">Выйти</a>
</div>