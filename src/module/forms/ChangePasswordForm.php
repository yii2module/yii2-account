<?php

namespace yii2module\account\module\forms;

use Yii;
use yii2module\account\domain\v2\forms\ChangePasswordForm as ApiChangePasswordForm;
use yii\helpers\ArrayHelper;

class ChangePasswordForm  extends ApiChangePasswordForm {
	
	public $new_password_repeat;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return ArrayHelper::merge(parent::rules(), [
			[['new_password_repeat'], 'trim'],
			[['new_password_repeat'], 'required'],
			[['new_password_repeat'], 'string', 'min' => 4],
			['new_password_repeat', 'compare', 'compareAttribute' => 'new_password',],
		]);
	}
	
	public function attributeLabels()
	{
		return ArrayHelper::merge(parent::attributeLabels(), [
			'new_password_repeat' => Yii::t('account/security', 'new_password_repeat'),
		]);
	}
}