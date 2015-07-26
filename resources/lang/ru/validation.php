<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Значение following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Значение :attribute должно быть принятым.",
	"active_url"           => "Значение :attribute имеет не верный формат URL.",
	"after"                => "Дата :attribute должна быть после даты :date.",
	"alpha"                => "Значение :attribute может содержать только буквы.",
	"alpha_dash"           => "Значение :attribute может содержать только буквы, цыфры и тире.",
	"alpha_num"            => "Значение :attribute может содержать только буквы и цыфры.",
	"array"                => "Значение :attribute должно быть массивом.",
	"before"               => "Дата :attribute должна быть до начала даты :date.",
	"between"              => [
		"numeric" => "Значение :attribute должно быть в диапазоне :min и :max.",
		"file"    => "Значение :attribute должно быть в диапазоне :min и :max килобайт.",
		"string"  => "Значение :attribute должно быть в диапазоне :min и :max символов.",
		"array"   => "Значение :attribute должно быть в диапазоне :min и :max элементов.",
	],
	"boolean"              => "Значение поля :attribute должно быть true или false.",
	"confirmed"            => "Значение :attribute не совпадает.",
	"date"                 => "Значение :attribute имеет неверный формат даты.",
	"date_format"          => "Значение :attribute не соответствует формату :format.",
	"different"            => "Значение :attribute и :other должны быть разными.",
	"digits"               => "Значение :attribute должно быть :digits digits.",
	"digits_between"       => "Значение :attribute должно быть between :min and :max digits.",
	"email"                => "Значение :attribute должно быть a valid email address.",
	"filled"               => "Значение поля :attribute обязательно для заполнения.",
	"exists"               => "Значение selected :attribute is invalid.",
	"image"                => "Значение :attribute должно быть an image.",
	"in"                   => "Значение selected :attribute is invalid.",
	"integer"              => "Значение :attribute должно быть an integer.",
	"ip"                   => "Значение :attribute должно быть a valid IP address.",
	"max"                  => [
		"numeric" => "Значение :attribute may not be greater than :max.",
		"file"    => "Значение :attribute may not be greater than :max kilobytes.",
		"string"  => "Значение :attribute may not be greater than :max characters.",
		"array"   => "Значение :attribute may not have more than :max items.",
	],
	"mimes"                => "Значение :attribute должно быть a file of type: :values.",
	"min"                  => [
		"numeric" => "Значение :attribute должно быть at least :min.",
		"file"    => "Значение :attribute должно быть at least :min kilobytes.",
		"string"  => "Значение :attribute должно быть at least :min characters.",
		"array"   => "Значение :attribute must have at least :min items.",
	],
	"not_in"               => "Значение selected :attribute is invalid.",
	"numeric"              => "Значение :attribute должно быть a number.",
	"regex"                => "Значение :attribute format is invalid.",
	"required"             => "Значение поля :attribute обязательно для заполнения.",
	"required_if"          => "Значение поля :attribute обязательно для заполнения, когда :other is :value.",
	"required_with"        => "Значение поля :attribute обязательно для заполнения, когда :values представлен.",
	"required_with_all"    => "Значение поля :attribute обязательно для заполнения, когда :values представлен.",
	"required_without"     => "Значение поля :attribute обязательно для заполнения, когда :values не представлен.",
	"required_without_all" => "Значение поля :attribute обязательно для заполнения, когда ничего из :values не представлено.",
	"same"                 => "Значение :attribute и :other должны соответствовать.",
	"size"                 => [
		"numeric" => "Значение :attribute должно быть :size.",
		"file"    => "Значение :attribute должно быть :size kilobytes.",
		"string"  => "Значение :attribute должно быть :size characters.",
		"array"   => "Значение :attribute должно содержать :size элементов.",
	],
	"unique"               => "Значение :attribute уже используется.",
	"url"                  => "Значение :attribute не по формату.",
	"timezone"             => "Значение :attribute должно быть соответствовать зоне.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| Значение following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
