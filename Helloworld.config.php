<?php

/**
 * Optional config file for Helloworld.module
 *
 * When present, the module will be configurable and the configurable properties
 * described here will be automatically populated to the module at runtime. 
 * 
 * While this shows the simplest method, this configuration can also be defined
 * in other ways, including directly in the module file. For more details: 
 * 
 * https://processwire.com/to/nmco/
 * https://processwire.com/to/emcwmf/
 * 
 * Note: to make any text translatable, wrap it with __('your text'); 
 * This will make that text translatable with PW's multi-language tools.
 * See the 'useHello' definition below (2nd field), for an example. 
 * 
 */

$config = array(
	
	'helloMessage' => array(
		'type' => 'text',  // can be any Inputfield module name
		'label' => 'Your hello world message',
		'description' => 'This is here as an example of a configurable module property.', 
		'notes' => 'The module can access this value any time from $this->helloMessage.', 
		'value' => 'Hello World', // default value
		'required' => true, 
	),
	
	'useHello' => array(
		'type' => 'radios',
		'label' => __('Enable hello world message?'), 
		'description' => __('This will make your hello world message display at the bottom of every page.'),
		'notes' => __('The hello message will only be shown to users with edit access to the page.'), 
		'options' => array(
			1 => __('Yes'),
			0 => __('No'),
		),
		'value' => 0,
	),
	
);