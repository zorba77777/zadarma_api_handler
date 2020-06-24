<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_account".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $sip_id
 *
 * @property UserCall[] $userCalls
 * @property UserCall[] $userCalls0
 * @property UserCall[] $userCalls1
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'phone', 'sip_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'phone' => 'Phone',
            'sip_id' => 'Sip ID',
        ];
    }

    /**
     * Gets query for [[UserCalls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCalls()
    {
        return $this->hasMany(UserCall::className(), ['account_id' => 'id']);
    }

    /**
     * Gets query for [[UserCalls0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCalls0()
    {
        return $this->hasMany(UserCall::className(), ['mentor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCalls1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCalls1()
    {
        return $this->hasMany(UserCall::className(), ['sip_id' => 'sip_id']);
    }
}
