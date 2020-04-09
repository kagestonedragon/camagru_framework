<?php

namespace Framework\Models\Auth;

use Framework\Models\Basic\Model;

class Logout extends Model
{
    protected function process()
    {
        global $USER;

        $USER->logout();
    }
}