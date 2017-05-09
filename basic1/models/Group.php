<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 *
 * @property Contact[] $contacts
 * @property GroupHasSchedule[] $groupHasSchedules
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
	public $manage_contact;
	
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            ['name', 'validateGroupName'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['manage_contact'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupHasSchedules()
    {
        return $this->hasMany(GroupHasSchedule::className(), ['group_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupQuery(get_called_class());
    }
    
	public function validateGroupName($attribute, $params)
    {
    	$id = (Yii::$app->user->isGuest)? 0: Yii::$app->user->id;
    	$group = $this->findOne([
		    'name' => $this->getAttribute($attribute),
    		'user_id' => $id,
		]);		
		
        if ($group !== null) {
            $this->addError($attribute, 'This group name exists. Please use another name.');
        }
    }
}
