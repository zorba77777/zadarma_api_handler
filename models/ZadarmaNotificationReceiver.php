<?php


namespace app\models;

class ZadarmaNotificationReceiver
{
    public static function saveCall($params)
    {
        if ($params['event'] == 'NOTIFY_END') {
            $mentor = UserAccount::findOne(['phone' => $params['caller_id']]);
            $user = UserAccount::findOne(['phone' => $params['called_did']]);
        } elseif ($params['event'] == 'NOTIFY_OUT_END') {
            $mentor = UserAccount::findOne(['phone' => $params['destination']]);
            $user = UserAccount::findOne(['phone' => $params['caller_id']]);
        } else {
            return false;
        }

        $call = new UserCall(
            [
                'id' => $params['pbx_call_id'],
                'account_id' => $user->id,
                'mentor_id' => $mentor->id,
                'sip_id' => $mentor->sip_id,
                'created_at' => $params['call_start'],
                'city' => null,
                'success' => $params['disposition'] == 'answered' ? 1 : 0,
                'cost_per_minute' => null,
                'duration' => $params['duration']
            ]
        );

        if ($call->save()) {
            return true;
        } else {
            return false;
        }
    }
}
