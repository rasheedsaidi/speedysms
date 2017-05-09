<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property integer $number
 * @property string $created_at
 * @property integer $group_id
 *
 * @property Group $group
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'number', 'group_id', 'user_id'], 'required'],
            [['group_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 20],
            //[['number'], 'unique'],
            //[['name', 'number'], 'exist'],
            ['group_id', 'validateName'],
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
            'number' => 'Number',
            'created_at' => 'Created At',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * @inheritdoc
     * @return ContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactQuery(get_called_class());
    }
    
public function validateName($attribute, $params)
    {
    	$id = (Yii::$app->user->isGuest)? 0: Yii::$app->user->id;
    	$group = $this->findOne([
		    'number' => $this->getAttribute('number'),
    		'user_id' => $id,
    		'group_id' => $this->getAttribute('group_id'),
		]);		
		
        if ($group !== null) {
            $this->addError($attribute, 'This group name exists. Please use another name.');
        }
    }
}
