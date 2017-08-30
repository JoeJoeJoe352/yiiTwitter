<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "tweet".
 *
 * @property integer $tweetid
 * @property integer $userid
 * @property string $text
 * @property string $date
 * @property integer $visits
 *
 * @property User $user
 */
class Tweet extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tweet';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userid', 'text', 'date', 'visits'], 'required'],
            [['userid', 'visits'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 160, 'min' => 10, 'message' => 'a tweet 10 és 160 karakter között legyen'],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'userid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'tweetid' => 'Tweetid',
            'userid' => 'Userid',
            'text' => 'Tweet',
            'date' => 'Dátum',
            'visits' => 'Látogatások száma',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['userid' => 'userid']);
    }

    public function increaseVisits() {
        $this->visits = $this->visits + 1;
    }

    public function getUserId() {
        return $this->userid;
    }

    public function getUserName() {
        $provider = new ActiveDataProvider([
            'query' => $this->getUser(),
        ]);
        
        $user = $provider->getModels();
        return $user[0]->getName();
    }

}
