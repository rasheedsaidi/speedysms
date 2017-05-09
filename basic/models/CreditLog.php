<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "creadit_log".
 *
 * @property integer $id
 * @property double $credit
 * @property integer $status
 * @property integer $credit_id
 * @property integer $user_id
 *
 * @property Credit $credit0
 * @property User $user
 */
class CreditLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credit_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['credit', 'credit_id', 'user_id'], 'required'],
            [['credit'], 'number'],
            [['status', 'credit_id', 'type', 'added_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'credit' => 'Credit',
            'status' => 'Status',
            'credit_id' => 'Credit ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCredit0()
    {
        return $this->hasOne(Credit::className(), ['id' => 'credit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return CreditLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CreditLogQuery(get_called_class());
    }
}
