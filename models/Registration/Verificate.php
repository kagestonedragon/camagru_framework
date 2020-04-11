<?php

namespace Framework\Models\Registration;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class Verificate extends Model
{
    const STATUS = [
        'ALREADY_VERIFIED' => 1,
        'NOT_VALID_TOKEN' => 0,
        'VERIFICATION' => 2,
    ];

    protected function process()
    {
        global $REQUEST;

        $token = $REQUEST->arGet['TOKEN'];
        $this->setStatus($this->validateVerification($token));
        if ($this->result['status'] == Verificate::STATUS['VERIFICATION']) {
            $this->verificate($token);
        }
    }

    private function verificate(string $token)
    {
        (new ORM('#users'))
            ->update([
                "verified" => '1',
            ])
            ->where('token=:token')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':token' => $token,
            ]);
    }

    private function validateVerification(string $token)
    {
        $result = (new ORM('#users'))
            ->select([
                'verified'
            ])
            ->where('token=:token')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':token' => $token,
            ]);

        if (empty($result)) {
            return (Verificate::STATUS['NOT_VALID_TOKEN']);
        } else if ($result['verified'] == 1) {
            return (Verificate::STATUS['ALREADY_VERIFIED']);
        } else {
            return (Verificate::STATUS['VERIFICATION']);
        }
    }
}