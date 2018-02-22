<?php

namespace yii2module\account\domain\v1\repositories\ar;

use Yii;
use yii2lab\domain\repositories\BaseRepository;
use yii2module\account\domain\v1\interfaces\repositories\SecurityInterface;
use yii2module\account\domain\v1\models\User;

class SecurityRepository extends BaseRepository implements SecurityInterface {
	
	public function changePassword($password, $newPassword) {
		$userId = Yii::$app->user->identity->getId();
		$userModel = User::find()->where(['id' => $userId])->one();
		$userModel->password_hash = Yii::$app->security->generatePasswordHash($newPassword);
		$userModel->save();
	}
	
	public function changeEmail($password, $email) {
	
	}
}