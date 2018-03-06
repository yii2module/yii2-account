<?php

namespace yii2module\account\domain\v2\repositories\ar;

use yii2lab\domain\repositories\ActiveArRepository;

class TempRepository extends ActiveArRepository {
	
	protected $modelClass = 'yii2module\account\domain\v2\models\UserRegistration';
	protected $primaryKey = 'login';
	
	public function oneByLogin($login) {
		$model = $this->oneModelByCondition(['login' => $login]);
		return $this->forgeEntity($model);
	}
	
}