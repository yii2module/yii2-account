<?php

namespace yii2module\account\domain\v2\repositories\traits;

use Yii;
use yii\web\NotFoundHttpException;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii2lab\domain\helpers\ErrorCollection;
use yii2module\account\domain\v2\entities\SecurityEntity;

trait SecurityTrait {
	
	abstract public function update(BaseEntity $entity);
	abstract public function one(Query $query = null);
	abstract public function oneById($id, Query $query = null);
	
	public function tableName() {
		return 'user_security';
	}
	
	public function fieldAlias() {
		return [
			'token' => 'auth_key',
		];
	}
	
	public function oneByToken($token, $type = null) {
		$query = Query::forge();
		$query->where('token',  $token);
		return $this->one($query);
	}
	
	public function validatePassword($userId, $password) {
		$securityEntity = $this->isValidPassword($userId, $password);
		if(!$securityEntity) {
			$error = new ErrorCollection();
			$error->add('password', 'account/auth', 'incorrect_password');
			throw new UnprocessableEntityHttpException($error);
		}
		return $securityEntity;
	}
	
	public function changePassword($password, $newPassword) {
		$userId = Yii::$app->user->id;
		$securityEntity = $this->validatePassword($userId, $password);
		$securityEntity->password_hash = Yii::$app->security->generatePasswordHash($newPassword);
		$this->update($securityEntity);
	}
	
	public function changeEmail($password, $email) {
		$userId = Yii::$app->user->id;
		$securityEntity = $this->validatePassword($userId, $password);
		$securityEntity->email = $email;
		$this->update($securityEntity);
	}
	
	/**
	 * @param $userId
	 * @param $password
	 *
	 * @return SecurityEntity|false
	 */
	private function isValidPassword($userId, $password) {
		$securityEntity = $this->oneById($userId);
		if(Yii::$app->security->validatePassword($password, $securityEntity->password_hash)) {
			return $securityEntity;
		}
		return false;
	}

}