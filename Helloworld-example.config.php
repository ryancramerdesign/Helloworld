<?php namespace ProcessWire;

/**
 * Optional config file for Helloworld.module 
 * 
 * This is just an example file that is not currently used. 
 * 
 * This is an alternative to using the getModuleConfigInputfields() method in 
 * in the HelloWorld.module.php file. This file is included here to demonstrate
 * this option but note that this module is not using it, so you can feel 
 * free to delete the file.
 * 
 * If you do opt to use this file then rename it to: Helloworld.config.php
 * and remove the getModuleConfigInputfields() method in the module file. 
 * 
 * When present, the module will be configurable and the configurable properties
 * described here will be automatically populated to the module at runtime. 
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
	)
);