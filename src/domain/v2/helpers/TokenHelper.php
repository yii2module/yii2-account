<?php

namespace yii2module\account\domain\v2\helpers;

use Yii;
use yii\base\InvalidArgumentException;
use yii2lab\extension\common\helpers\StringHelper;
use yii2lab\extension\yii\helpers\ArrayHelper;
use yii2module\account\domain\v2\dto\TokenDto;
use yii2module\account\domain\v2\entities\LoginEntity;
use yii2module\account\domain\v2\filters\token\BaseTokenFilter;

class TokenHelper {
	
	public static function login($body, $ip, $types = []) {
		$type = ArrayHelper::getValue($body, 'token_type');
		$type = self::prepareType($type, $types);
		//$type = !empty($type) ? $type : ArrayHelper::firstKey($this->tokenAuthMethods);
		$definitionFilter = ArrayHelper::getValue($types, $type);
		/*if(!$definitionFilter) {
			$error = new ErrorCollection();
			$error->add('tokenType', 'account/auth', 'token_type_not_found');
			throw new UnprocessableEntityHttpException($error);
		}*/
		/** @var BaseTokenFilter $filterInstance */
		$filterInstance = Yii::createObject($definitionFilter);
		$filterInstance->type = $type;
		$loginEntity = $filterInstance->login($body, $ip);
		return $loginEntity;
	}
	
    public static function authByToken($SourceToken, $types = []) {
	    $tokenDto = self::forgeDtoFromToken($SourceToken);
	    $type = $tokenDto->type;
	    $token = $tokenDto->token;
	    $type = self::prepareType($type, $types);
	    $definition = $types[$type];
        $loginEntity = self::runAuthFilter($definition, $token);
        if(!$loginEntity instanceof LoginEntity) {
	        return null;
        }
	    AuthHelper::setToken($token);
        return $loginEntity;
    }
	
    private static function prepareType($type, $types) {
		if(empty($types)) {
			throw new InvalidArgumentException(Yii::t('account/auth', 'empty_token_type_list'));
		}
	    if(empty($type)) {
		    $type = ArrayHelper::firstKey($types);
	    } elseif(empty($types[$type])) {
			$message = Yii::t('account/auth', 'token_type_not_found {actual_types}', ['actual_types' => implode(', ', array_keys($types))]);
	    	throw new InvalidArgumentException($message);
	    }
	    return $type;
    }
    
	private static function runAuthFilter($definition, $token) {
		/** @var BaseTokenFilter $filter */
		$filter = Yii::createObject($definition);
		$loginEntity = $filter->authByToken($token);
		return $loginEntity;
	}
	
	/**
	 * @param $token
	 *
	 * @return TokenDto|null
	 */
	public static function forgeDtoFromToken($token) {
        $token = trim($token);
        if(empty($token)) {
            return null;
        }
	    $token = trim($token);
	    $token = StringHelper::removeDoubleSpace($token);
        $tokenSegments = explode(SPC, $token);
	    $countSegments = count($tokenSegments);
       
        $isValid = $countSegments == 1 || $countSegments == 2;
        if(!$isValid) {
            throw new InvalidArgumentException('Invalid token format');
        }
		$tokenDto = new TokenDto();
        if(count($tokenSegments) == 1) {
	        $tokenDto->type = null;
	        $tokenDto->token = $tokenSegments[0];
        } elseif(count($tokenSegments) == 2) {
	        $tokenDto->type = strtolower($tokenSegments[0]);
	        $tokenDto->token = $tokenSegments[1];
        }
        return $tokenDto;
    }

}
