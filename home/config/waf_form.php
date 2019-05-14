<?php
  // Applied in /src/View/AppView.php
	return [
	  'button' => '<button{{attrs}} class="button btn">{{text}}</button>' . "\n",
	  'classbutton' => '<button{{attrs}}>{{text}}</button>' . "\n",
	  'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span class="control"></span>' . "\n",
	  'checkboxWrapper' => '<div class="form-item form-item-submitted-checkbox-{{name}} form-type-checkbox checkbox">'."\n".'{{label}}'."\n".'</div>' . "\n",
	  'fieldset' => '<fieldset{{attrs}}>'."\n".'<div class="panel-body">{{content}}</div>'."\n".'</fieldset>' . "\n",
		'input'=>'<input type="{{type}}" name="{{name}}" class="form-control form-input form-{{type}} {{type}}" {{attrs}} />' . "\n",
		'inputContainer' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}}">{{content}}</div>' . "\n",
		'inputContainerError' => '<div class="webform-component form-item form-type-input form-type-{{type}} {{type}}{{required}} error">{{content}}{{error}}</div>' . "\n",
		'label' => '<label class="control-label" {{attrs}}>{{text}}</label>' . "\n",
		'legend' => '<legend class="panel-heading">{{text}}</legend>' . "\n",
		'nestingLabel' => '{{hidden}}<label class="control-label"{{attrs}}>{{input}}{{text}}</label>' . "\n",
		'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>' . "\n",
		'select' => '<select name="{{name}}" class="form-control form-select select" {{attrs}}>{{content}}</select>' . "\n",
		'radio' => '<input class="form-radio" type="radio" name="{{name}}" value="{{value}}"{{attrs}}><span class="control"></span>' . "\n",
    'radioWrapper' => '<div class="form-item form-type-radio radio">'."\n".'{{label}}'."\n".'</div>' . "\n",
    'textarea' => '<textarea class="form-control form-textarea" name="{{name}}"{{attrs}}>{{value}}</textarea>' . "\n",
	];
