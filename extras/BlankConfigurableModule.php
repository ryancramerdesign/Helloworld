<?php namespace ProcessWire;

/**
 * Self contained blank configurable module template
 * 
 * If you want to use this file it must be renamed to: 
 * YourModuleName.module.php before ProcessWire will recognize it.
 * 
 * This is a self contained module that requires no other files. 
 * 
 * Note that this module is a blank module template and does not 
 * actually do anything other than be available to install/uninstall
 * in its present state. 
 *
 * Copyright [year] by [your name]
 * This module licensed under [choose your license: MPL 2.0 or MIT]
 * 
 * @property string $something
 * 
 */

class BlankConfigurableModule extends WireData implements Module, ConfigurableModule {

	/**
	 * Get module info (or use an external ModuleName.info.php file)
	 * 
	 * @return array
	 * 
	 */
	public static function getModuleInfo() {
		return array(
			'title' => 'Your module title here',
			'summary' => 'Your module description here',
			'version' => 1,
		);
	}

	/**
	 * Construct
	 *
	 */
	public function __construct() {
		parent::__construct();
		$this->set('something', 'Some configuration value'); // set default config value
	}

	/**
	 * Initialize the module 
	 *
	 */
	public function init() { }

	/**
	 * ProcessWire API ready (for autoload modules only, remove otherwise)
	 *
	 */
	public function ready() { }

	/**
	 * Build module configuration inputs
	 *
	 * @param InputfieldWrapper $inputfields
	 *
	 */
	public function getModuleConfigInputfields(InputfieldWrapper $inputfields) {
		$modules = $this->wire()->modules;
		/** @var InputfieldText $f */
		$f = $modules->get('InputfieldText');
		$f->attr('name', 'something');
		$f->label = $this->_('Some configuration property');
		$f->val($this->something);
		$inputfields->add($f);
	}

	/**
	 * Optional method that is called when the module version is upgraded
	 *
	 * @param string $fromVersion From version string i.e. '1.2.3'
	 * @param string $toVersion To version string i.e. '1.2.4'
	 *
	 */
	public function upgrade($fromVersion, $toVersion) { }

	/**
	 * Optional method called when the module is installed
	 *
	 */
	public function install() { }

	/**
	 * Optional method called when the module is uninstalled
	 *
	 */
	public function uninstall() { }
}
