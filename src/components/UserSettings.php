<?php

namespace codexten\yii\user\settings\components;

use codexten\yii\user\settings\models\UserSetting;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\Component;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class UserSettings
 *
 * @package codexten\yii\user\settings\components
 *
 * @property ActiveQuery $baseQuery
 * @property Integer $userId
 */
class UserSettings extends Component
{
    public $modelClass = UserSetting::class;

    public $cacheKey = 'userSettings';

    /**
     * @var integer
     */
    private $_userId;

    public function init()
    {
        parent::init();

        if (Yii::$app->hasProperty('user') && $this->_userId === null && !Yii::$app->user->isGuest) {
            $this->_userId = Yii::$app->user->id;
        }

    }


    /**
     * @param  Integer  $userId
     */
    public function setUserId(Integer $userId)
    {
        $this->_userId = $userId;
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseQuery($userId = null)
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;

        return (new ActiveQuery($modelClass))->andWhere(['user_id' => $userId ?: $this->_userId]);
    }

    /**
     * @param  array  $attributes
     *
     * @return ActiveRecord
     */
    public function getModel($attributes = [])
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;

        $attributes = ArrayHelper::merge(['user_id' => $this->_userId,], $attributes);

        $model = $modelClass::findOne($attributes);
        if ($model) {
            return $model;
        }

        return new $modelClass($attributes);
    }

    /**
     * @param $key
     * @param $value
     * @param  null  $userId
     * @return bool
     */
    public function set($key, $value, $userId = null)
    {
        $attributes = ['key' => $key];
        if ($userId) {
            $attributes['user_id'] = $userId;
        }
        $model = $this->getModel($attributes);
        $model->value = $value;
        return $model->save();
    }

    /**
     * @param $key
     * @param  null  $default
     * @param  null  $userId
     * @return mixed|null
     */
    public function get($key, $default = null, $userId = null)
    {

        $model = $this->getBaseQuery($userId)->andWhere(['key' => $key])->one();

        return $model ? $model['value'] : $default;
    }
}
