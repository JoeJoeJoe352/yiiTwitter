<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $userid
 * @property string $name
 * @property string $email
 * @property string $pass
 *
 * @property Tweet[] $tweets
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email', 'pass'], 'required', 'message' => 'Kérlek töltsd ki minden mezőt.'],
            [['name', 'email', 'pass'], 'string', 'max' => 30],
            ['name', 'unique', 'message' => 'Már van felhasználó ezen a néven'],
            ['pass', 'string', 'min' => 6, 'message' => 'A jelszó legyen 6 és 30 karakter között', 'on' => "login"],
            ['email', 'email', 'message' => 'Kérlek e-mail formátumot használj'],
            ['email', 'unique', 'message' => 'Ez az e-mail cím már foglalt'],
            ['name', 'match', 'pattern' => '/^[\*a-zA-Z0-9]{0,30}$/','message' => 'Nem megengedett karaktert használtál. Kérlek csak ékezet nélküli betűket és számokat használj']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'userid' => 'Userid',
            'name' => 'Név',
            'email' => 'Email',
            'pass' => 'Jelszó',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweets() {
        return $this->hasMany(Tweet::className(), ['userid' => 'userid'])->orderBy("date")->asArray;
    }

    public function getAuthKey(): string {
        return $this->auth_key;
    }

    public function getId() {
        return $this->userid;
    }
    
    public function getName(){
        return $this->name;
    }

    public function validateAuthKey($authKey): bool {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id): IdentityInterface {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface {
        return static::findOne(['access_token' => $token]);
    }

    
    
}
