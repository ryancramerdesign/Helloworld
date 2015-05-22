<?php

/**
 * Module info file that tells ProcessWire about this module. 
 * 
 * If you prefer to keep everything in the main module file, you can move this 
 * to a static getModuleInfo() method in the Helloworld.module.php file, which 
 * would return the same array as below. 
 * 
 * Note: When updating this info for an already-installed module, you'll need
 * to do a Modules > Refresh before you see your updated info. 
 * 
 */

$info = array(
	
	// The module title, typically a little more descriptive than the class name
	'title' => 'Hello World',

	// version number (integer)
	'version' => 3,

	// summary is brief description of what this module is
	'summary' => 'An example module used for demonstration purposes.',

	// Optional URL to more information about the module
	'href' => 'https://processwire.com',

	// singular=true: indicates that only one instance of the module is allowed.
	// This is usually what you want for modules that attach hooks. 
	'singular' => true,

	// autoload=true: indicates the module should be started with ProcessWire.
	// This is necessary for any modules that attach runtime hooks, otherwise those
	// hooks won't get attached unless some other code calls the module on it's own.
	// Note that autoload modules are almost always also 'singular' (seen above).
	'autoload' => true,

	// Optional font-awesome icon name, minus the 'fa-' part
	'icon' => 'smile-o',

	// Optionally describe what version of ProcessWire (or other modules) are required.
	// To specify more modules, separate each with a comma (CSV) or make this an array.
	'requires' => 'ProcessWire>=2.6.0',
	
	// for more properties that you can include in your module info, see comments 
	// the file: /wire/core/Module.php
);