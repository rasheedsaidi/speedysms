<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $dob
 * @property integer $phone1
 * @property integer $phone2
 * @property string $address
 * @property string $update_at
 * @property integer $user_id
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dob', 'update_at'], 'safe'],
            [['phone1', 'phone2', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'dob' => 'Dob',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'address' => 'Address',
            'update_at' => 'Update At',
            'user_id' => 'User ID',
        ];
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
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
