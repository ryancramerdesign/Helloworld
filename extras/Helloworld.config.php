<?php namespace ProcessWire;

/**
 * Optional external config file for Helloworld.module 
 * 
 * This is what defines the inputs that appear on your module configuration
 * screen in the admin. 
 * 
 * This is an alternative to using the getModuleConfigInputfields() method in 
 * in the HelloWorld.module.php file. This file is included here to demonstrate
 * this alternative option but note that the module does not use it unless it’s 
 * in the same directory as the module. As a result, this file is here only for
 * demonstration purposes and not currently used by the Helloworld module. 
 * 
 * If you do want to use this external config file then you would move it into
 * the parent directory (where the .module.php file is) and remove the 
 * getModuleConfigInputfields() method that’s in the .module.php file. 
 * 
 * Note: to make any text translatable, wrap it with __('your text'); 
 * This will make that text translatable with PW’s multi-language tools.
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
	)
);