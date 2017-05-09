<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_log".
 *
 * @property integer $id
 * @property string $mobile_no
 * @property double $credit_used
 * @property string $sent_at
 * @property integer $status
 * @property integer $message_id
 * @property string $sender_id
 *
 * @property Message $message
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
            [['mobile_no', 'message_id', 'user_id'], 'required'],
            [['message_id'], 'integer'],
            [['credit_used'], 'number'],
            [['sent_at', 'mobile_no', 'country', 'sender_id', 'status', 'sms_return_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile_no' => 'Mobile Number',
            'credit_used' => 'Credit Used',
            'sent_at' => 'Time Sent',
            'status' => 'SMS Status',
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
        	'sender_id' => 'Sender ID',
        	'country' => 'Country'
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
