<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property integer $message_id
 * @property string $started_at
 * @property string $completed_at
 * @property string $created_at
 *
 * @property GroupHasSchedule[] $groupHasSchedules
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'started_at'], 'required'],
            [['message_id'], 'integer'],
            [['completed_at', 'created_at', 'year', 'month', 'day', 'hour', 'minute', 'second', 'status', 'scheduled_date', 'scheduled_time', 'scheduled_datetime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupHasSchedules()
    {
        return $this->hasMany(GroupHasSchedule::className(), ['schedule_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScheduleQuery(get_called_class());
    }
}
