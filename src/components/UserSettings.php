<?php

namespace codexten\yii\user\settings\components;

use codextend\yii\user\settings\models\UserSetting;
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

        if ($this->_userId === null && !Yii::$app->user->isGuest) {
            $this->_userId = Yii::$app->user->id;
        }

    }


    /**
     * @param Integer $userId
     */
    public function setUserId(Integer $userId)
    {
        $this->_userId = $userId;
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseQuery()
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;

        return (new ActiveQuery($modelClass))->andWhere(['user_id' => $this->_userId]);
    }

    /**
     * @param array $attributes
     *
     * @return ActiveRecord
     */
    public function getModel($attributes = [])
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;

        $attributes = ArrayHelper::merge(['user_id' => $this->_userId,], $attributes);

        return new $modelClass($attributes);
    }

    public function set($key, $value)
    {
        $model = $this->getModel(['key' => $key, 'value' => $value]);

        return $model->save();
    }

    public function get($key, $default = null)
    {
        $model = $this->getBaseQuery()->andWhere(['key' => $key])->one();

        return $model ? $model['value'] : $default;
    }
}
