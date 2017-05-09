<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $number
 * @property string $sender
 * @property integer $type
 * @property string $body
 * @property integer $length
 * @property string $status
 *
 * @property MessageLog[] $messageLogs
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'flag', 'status'], 'integer'],
            [['body'], 'string'],
            [['number'], 'string', 'max' => 20],
            [['sender'], 'string', 'max' => 50],
            [['sender', 'type', 'length', 'body'], 'required']
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
            'sender' => 'Sender ID',
            'type' => 'Type',
            'body' => 'Body',
            'length' => 'Message Status',
        	'status' => 'Status',
        	'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageLogs()
    {
        return $this->hasMany(MessageLog::className(), ['message_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }   
	
}
