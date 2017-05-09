<?php

namespace app\models;

//class User extends \yii\base\Object implements \yii\web\IdentityInterface
use yii\db\ActiveRecord;

use yii\base\Model;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $full_name;
    public $role_id;
    public $status;
    public $created_at;
    public $updated_at;
    public $authKey;
    public $accessToken;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const ROLE_RESELLER = 2;
    
	public function rules()
    {
        return [
            [['full_name', 'username', 'password'], 'required'],
            [['role_id', 'full_name', 'status', 'created_at', 'updated_at'], 'safe'],
            ['password', 'validatePassword'],
            ['username', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
