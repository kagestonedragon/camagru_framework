<?php

namespace Framework\Components;

/**
 * Class Profile
 * @package Framework\Components
 *
 * TODO
 */
class Profile extends Component
{
    const STATUS_AUTHORIZED = 'authorized';
    const STATUS_GUEST = 'guest';

    protected function Process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            $this->result['status'] = Profile::STATUS_AUTHORIZED;
        } else {
            $this->result['status'] = Profile::STATUS_GUEST;
        }
    }
}