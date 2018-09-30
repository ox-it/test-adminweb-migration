<?php

	return [
	  'button' => '<button{{attrs}} class="button btn">{{text}}</button>',
	  'checkboxWrapper' => '<div class="form-item form-item-submitted-checkbox-{{name}} form-type-checkbox checkbox">{{label}}</div>',
	  'fieldset' => '<fieldset{{attrs}}><div class="panel-body">{{content}}</div></fieldset>',
		'input'=>'<input type="{{type}}" name="{{name}}" class="form-control form-input form-{{type}} {{type}}" {{attrs}} />',
		'inputContainer' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}}">{{content}}</div>',
		'inputContainerError' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}} error">{{content}}{{error}}</div>',
		'label' => '<label class="control-label" {{attrs}}>{{text}}</label>',
		'legend' => '<legend class="panel-heading">{{text}}</legend>',
		'select' => '<select name="{{name}}" class="form-control form-select select" {{attrs}}>{{content}}</select>',
		'radio' => '<input class="form-radio" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
    'radioWrapper' => '<div class="form-item form-item-submitted-radio form-type-radio radio">{{label}}</div>',
    'textarea' => '<textarea class="form-control form-textarea" name="{{name}}"{{attrs}}>{{value}}</textarea>',
	];
