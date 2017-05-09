<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sent_message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property string $posted_at
 * @property string $updated_at
 */
class SentMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sent_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['body'], 'string'],
            [['posted_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'body' => 'Body',
            'posted_at' => 'Posted At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return SentMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SentMessageQuery(get_called_class());
    }
}
