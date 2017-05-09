<?php

namespace app\models;

use amnah\yii2\user\models\User;

use Yii;

/**
 * This is the model class for table "credit".
 *
 * @property integer $id
 * @property double $value
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user_id
 *
 * @property CreaditLog[] $creaditLogs
 * @property User $user
 */
class Credit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'created_at', 'user_id', 'type'], 'required'],
            [['amount', 'price_id'], 'number'],
            [['created_at', 'updated_at',], 'safe'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount to add',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreaditLogs()
    {
        return $this->hasMany(CreaditLog::className(), ['credit_id' => 'id']);
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
     * @return CreditQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CreditQuery(get_called_class());
    }
}
