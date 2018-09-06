<?php

	return [
	  'button' => '<button{{attrs}} class="button btn">{{text}}</button>',
	  'fieldset' => '<fieldset{{attrs}}><div class="panel-body">{{content}}</div></fieldset>',
		'input'=>'<input type="{{type}}" name="{{name}}" class="form-control form-input form-{{type}} {{type}}" {{attrs}} />',
		'inputContainer' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}}">{{content}}</div>',
		'inputContainerError' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}} error">{{content}}{{error}}</div>',
		'legend' => '<legend class="panel-heading">{{text}}</legend>',
		'select' => '<select name="{{name}}" class="form-control form-select select" {{attrs}}>{{content}}</select>',
	];
