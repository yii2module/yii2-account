<?php

namespace yii2module\account\domain\v2\repositories\core;

use yii2lab\domain\repositories\CoreRepository;
use common\enums\app\ApiVersionEnum;

class SecurityRepository extends CoreRepository {
	
	public $baseUri = 'security';
	public $version = 'v4';
	
	public function changePassword($password, $newPassword) {
		$response = $this->put('password', [
			'password' => $password,
			'new_password' => $newPassword,
		]);
	}
	
	public function changeEmail($password, $email) {
		$response = $this->put('email', [
			'password' => $password,
			'email' => $email,
		]);
	}
	
}