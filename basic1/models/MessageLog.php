<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_log".
 *
 * @property integer $id
 * @property integer $number
 * @property double $credit_deducted
 * @property string $sent_at
 * @property integer $status
 * @property integer $message_id
 * @property integer $user_id
 *
 * @property Message $message
 * @property User $user
 */
class MessageLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'message_id', 'user_id'], 'required'],
            [['number', 'status', 'message_id', 'user_id'], 'integer'],
            [['credit_deducted'], 'number'],
            [['sent_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'credit_deducted' => 'Credit Deducted',
            'sent_at' => 'Sent At',
            'status' => 'Status',
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
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
     * @return MessageLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageLogQuery(get_called_class());
    }
}
