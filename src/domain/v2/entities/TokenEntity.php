<?php

namespace yii2module\account\domain\v2\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class TokenEntity
 * 
 * @package yii2module\account\domain\v2\entities
 * 
 * @property $user_id
 * @property $token
 * @property $ip
 * @property $platform
 * @property $browser
 * @property $version
 * @property $created_at
 * @property $expire_at
 * @property $expire
 */
class TokenEntity extends BaseEntity {

	protected $user_id;
	protected $token;
	protected $ip;
	protected $platform;
	protected $browser;
	protected $version;
	protected $created_at = TIMESTAMP;
	protected $expire_at;
	
	public function rules() {
		return [
			[['token', 'ip', 'platform', 'browser', 'version'], 'trim'],
			[['user_id', 'token', 'ip', 'created_at', 'expire_at'], 'required'],
			[['user_id', 'created_at', 'expire_at'], 'integer'],
			['expire_at', 'compare', 'compareAttribute' => 'created_at', 'operator' => '>'],
		];
	}
	
}
