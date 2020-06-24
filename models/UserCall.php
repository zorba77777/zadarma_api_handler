<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_call".
 *
 * @property int $id
 * @property int|null $account_id
 * @property int|null $mentor_id
 * @property string|null $sip_id
 * @property string|null $created_at
 * @property string|null $city
 * @property int|null $success
 * @property float|null $cost_per_minute
 * @property string|null $duration
 *
 * @property UserAccount $account
 * @property UserAccount $mentor
 * @property UserAccount $sip
 */
class UserCall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_call';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_id', 'mentor_id', 'success'], 'integer'],
            [['created_at', 'duration'], 'safe'],
            [['sip_id', 'city'], 'string', 'max' => 255],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['mentor_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['mentor_id' => 'id']],
            [['sip_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['sip_id' => 'sip_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'mentor_id' => 'Mentor ID',
            'sip_id' => 'Sip ID',
            'created_at' => 'Created At',
            'city' => 'City',
            'success' => 'Success',
            'cost_per_minute' => 'Cost Per Minute',
            'duration' => 'Duration',
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'account_id']);
    }

    /**
     * Gets query for [[Mentor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMentor()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'mentor_id']);
    }

    /**
     * Gets query for [[Sip]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSip()
    {
        return $this->hasOne(UserAccount::className(), ['sip_id' => 'sip_id']);
    }
}
