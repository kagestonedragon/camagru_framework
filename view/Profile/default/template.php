<?php

/**
 * @var $result
 */

if ($result['status'] == 'authorized') {
    require_once('profile.php');
} else if ($result['status'] == 'guest') {
    require_once('guest.php');
}