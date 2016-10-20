<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $country_id
 * @property string $username
 * @property string $email
 * @property string $password
 *
 * @property Profile[] $profiles
 * @property Country $country
 */
class User extends \yii\db\ActiveRecord
{
    public $country_name;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['username', 'email', 'password','country_name'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['email','username'], 'unique'],
            [['email'], 'string', 'max' => 100],
            [['password'],'string', 'min' => 6,'max' => 100],
            [['country_name'], 'setCountry'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'country_name' => 'Country',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function setCountry(){
        $this->country_id = Country::findOne(['name' => $this->country_name])->id;
    }
}
