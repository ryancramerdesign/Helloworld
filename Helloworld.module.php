<?php namespace ProcessWire;

/**
 * ProcessWire “Hello world” demonstration module
 *
 * Demonstrates the Module interface and how to add hooks.
 * This version of Helloworld requires ProcessWire 3.0 or newer.
 * 
 * Copyright [year] by [your name]
 * This module licensed under [choose your license: MPL 2.0 or MIT]
 * 
 * Below we use phpdoc syntax to identify the configurable properties
 * from our Helloworld.config.php file. This is optional, but may be
 * helpful if you are using an editor that recognizes phpdoc syntax.
 * These properties will be automatically populated to your module, regardless
 * of whether or not you mention them here. See the Helloworld.config.php file.
 * 
 * MODULE CONFIGURATION PROPERTIES
 * ===============================
 * @property string $helloMessage The hello world message to display
 * @property int $useHello Whether or not our hello message is enabled
 *
 */

class Helloworld extends WireData implements Module, ConfigurableModule {

	/**
	 * Construct
	 * 
	 * This is often used to set default values for configuration settings
	 * 
	 */
	public function __construct() {
		parent::__construct();
		$this->set('helloMessage', 'Hello World');
		$this->set('useHello', 0);
		// you may remove this method if you do not need it
	}

	/**
	 * Initialize the module (optional)
	 *
	 * ProcessWire calls this method when the module is loaded. At this stage, all
	 * module configuration values have been populated.  
	 * 
	 * For “autoload” modules, this will be called before ProcessWire’s API is ready. 
	 * This is a good place to attach hooks (as is the “ready” method).
	 *
	 */
	public function init() {

		// Add a hook after the $pages->save, to issue a notice every time a page is saved
		$this->pages->addHookAfter('saved', $this, 'pageSaveHookExample'); 

		// note use of our configurable property: $this->useHello
		if($this->useHello) {
			// Add a hook after each page is rendered and modify the output
			$this->addHookAfter('Page::render', $this, 'pageRenderHookExample');
		}

		// Add a 'hello' method to every page that returns "Hello World".
		// Use "echo $page->hello();" in your template file to display output
		// Optionally specify an argument to include it in the return value. 
		$this->addHook('Page::hello', $this, 'pageHelloHookExample'); 

		// When adding a hook, you can optionally make the function right there, rather than
		// putting it somewhere else in the class, as we show in the examples below. 
		// This works for any type of hook. 
		
		// Add a 'hello_world' property to every page that returns "Hello [user]"
		// Use "echo $page->hello_world;" in your template file to display output.
		$this->addHookProperty('Page::hello_world', function(HookEvent $event) {
			// Note: you can access any PW API variable directly from the $event object,
			// as you can with most ProcessWire objects. Here we use it to access the
			// $user API variable. 
			$event->return = sprintf(__('Hello %s'), $event->user->name); 
		}); 

		// Example of page editor hook
		// Displays a hello notifiation when a superuser is editing the homepage
		$this->addHookBefore('ProcessPageEdit::execute', function(HookEvent $event) {
			$process = $event->object; /** @var ProcessPageEdit $process */
			$page = $process->getPage(); // getPage() is a method in ProcessPageEdit
			$user = $event->user; /** @var User $user */
			if($page->id === 1 && $user->isSuperuser()) {
				// superuser is editing the homepage
				$event->message(sprintf(__('Hello %s - You are editing the homepage!'), $user->name));
			} else {
				// user editing some page or it is not a superuser
			}
		});
	
		// Examples of a URL hooks (requires ProcessWire 3.0.173+):
		// https://processwire.com/blog/posts/pw-3.0.173/
		
		// This example outputs "Hello World" when you access the URL /hello/world/
		$this->addHook('/hello/world/', function(HookEvent $event) {
			return __('Hello World');
		});
		
		// Access URL /hello/planet/earth, /hello/planet/mars, or /hello/planet/jupiter
		$this->addHook('/hello/planet/(earth|mars|jupiter)', function(HookEvent $event) {
			return "Hello " . $event->arguments(1);
		});
		
		// Example of using named arguments: try accessing /hello/neptune, etc.
		$this->addHook('/hello/{planet}', function(HookEvent $event) {
			$planet = $event->arguments('planet'); // get the argument by name
			$planet = wire()->sanitizer->word($planet); // reduce to just 1st word
			return "Hello $planet";
		});
	}

	/**
	 * Called when ProcessWire’s API is ready (optional)
	 * 
	 * This optional method is similar to that of init() except that it is called
	 * after the current $page has been determined and the API is fully ready to use.
	 * Use this method instead of (or in addition to) the init() method if your 
	 * initialization requires that the `$page` API variable is available.
	 * 
	 */
	public function ready() {
		$page = $this->wire()->page; 
		$user = $this->wire()->user; 
		if($page->template->name === 'admin' && $user->isLoggedin()) {
			// i.e. do something that only applies users in the admin
		}
		// You may remove this method if you do not need it
	}

	/**
	 * Hook after $pages->save() method 
	 * 
	 * Hooks into the $pages->save() method and displays a notice every time a page is saved.
	 * 
	 * @param HookEvent $event
	 *
	 */
	public function pageSaveHookExample(HookEvent $event) {
		
		// We ask for the first argument passed to the $pages->save($page) method, which is argument 0. 
		// If preferred, you can also ask for an argument by name, i.e. $event->arguments('page'); 
		
		$page = $event->arguments(0); 
		$this->message($this->helloMessage . ' - ' . sprintf($this->_('You saved %s'), $page->path)); 
	}

	/**
	 * Hook after Page::render()
	 * 
	 * Hooks into every page after it's rendered and adds your hello message text at the bottom.
	 * 
	 * Interesting note: Page::render() is itself a hook, added by /wire/modules/PageRender.module,
	 * so this method is actually hooking to a hook! But everything works the same as if the
	 * method actually existed in the Page class, so you don't even need to know this. 
	 * 
	 * @param HookEvent $event
	 *
	 */
	public function pageRenderHookExample(HookEvent $event) {

		// The $event->object is always the object hooked to, in this case a Page object,
		// since the hook is to Page::render.
		$page = $event->object; /** @var Page $page */
		
		// we are only going to show this message if the user is allowed to edit the page
		// this makes this silly module a little more production site friendly, so we 
		// aren't messing up anything on the front end, except for you hopefully! 
		if(!$page->editable()) return;

		// We are going to insert our configurable helloMessage into the output,
		// but first we entity encode it for safety (to keep HTML out of it)
		$helloMessage = $this->wire()->sanitizer->entities($this->helloMessage);
		
		// if not in the admin, tell them they can click it to edit the page
		if($page->template->name !== 'admin') {
			$helloMessage .= '<br>' . $this->_('Click here to edit this page');
		}
		
		// We are styling our output so that we can be certain it'll be visible on the
		// front-end of the site. As a bonus, we'll make the hello message link to the
		// page editor for whatever page it is seen on. 
		
		$out = "
			<div style='background: red; padding: 10px; text-align: center;'>
				<a href='$page->editUrl' style='color: #fff; font-weight: bold;'>
					$helloMessage
				</a>
			</div>
			";

		// Add a hello message right before the closing body tag.
		// Note: $event->return is always the return value of the hooked method,
		// so we are simply modifying that return value. 
		
		$event->return = str_replace("</body>", "$out</body>", $event->return);
	}

	/**
	 * Hook to Page::hello
	 * 
	 * This adds a hello() method (not property) to every Page object. When accessed, via 
	 * $page->hello(); (where $page is any Page) it simply returns the string "Hello World".
	 * 
	 * If you pass an argument to it, it will include that in the hello message.
	 * 
	 * @param HookEvent $event
	 *
	 */
	public function pageHelloHookExample(HookEvent $event) {
	
		// determine the page that our method hook was called on
		$page = $event->object; /** @var Page $page */
		
		// return our configurable hello message, along with some text indicating what the page is
		$event->return = $this->helloMessage . ' - ' . sprintf($this->_('This is page %s'), $page->path);
		
		if($event->arguments(0)) {
			// if the method call had an argument, append it in the return value, just to
			// demonstrate how your hook methods can use arguments. 
			$event->return .= " - " . $event->arguments(0);
		}
	}

	/**
	 * Build module configuration inputs
	 * 
	 * If you prefer configuration can also be specified more declaratively with a PHP 
	 * array in an external configuration file. See the /extras/Helloworld.config.php 
	 * file included in this module’s files for an example. 
	 * 
	 * @param InputfieldWrapper $inputfields
	 * 
	 */
	public function getModuleConfigInputfields(InputfieldWrapper $inputfields) {
		$modules = $this->wire()->modules;

		/** @var InputfieldText $f */
		$f = $modules->get('InputfieldText');
		$f->attr('name', 'helloMessage');
		$f->label = $this->_('Your hello world message');
		$f->description = $this->_('This is here as an example of a configurable module property.');
		$f->val($this->helloMessage);
		$f->required = true;
		$f->icon = 'smile-o';
		$inputfields->add($f);

		/** @var InputfieldToggle $f */
		$f = $modules->get('InputfieldToggle');
		$f->attr('name', 'useHello');
		$f->label = $this->_('Use hello world message?');
		$f->description = $this->_('This will make your hello world message display at the bottom of every page.');
		$f->notes = $this->_('The hello message will only be shown to users with edit access to the page.');
		$f->val($this->useHello);
		$inputfields->add($f);
	}

	/**
	 * Optional method that is called when the module version is upgraded
	 * 
	 * @param string $fromVersion From version string i.e. '1.2.3'
	 * @param string $toVersion To version string i.e. '1.2.4'
	 * 
	 */
	public function ___upgrade($fromVersion, $toVersion) {
		// you may remove this method if you do not need it
		if(version_compare($fromVersion, '0.0.3', '<=')) {
			// user upgraded from version 3 or prior
			$this->message("Congratulations on upgrading to version $toVersion"); 
		}
	}

	/**
	 * Optional method called when the module is installed
	 * 
	 * This method is typically used to create DB tables or install files
	 * in the correct location, etc. Should the installation need to fail
	 * for some reason, it should `throw new WireException('error description');`
	 * 
	 */
	public function ___install() {
		// Example of creating a DB table (example only, we don’t use it for anything)
		// you may remove this method if you do not need it
		$sql = "
			CREATE TABLE hello_world (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(128)
			) ENGINE={$this->config->dbEngine} DEFAULT CHARSET={$this->config->dbCharset}
		";
		try {
			$this->wire()->database->exec($sql);
		} catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	/**
	 * Optional method called when the module is uninstalled
	 *
	 * This method undoes anything that the install() method did.
	 * For instance, remove installed DB tables, files, etc.
	 *
	 */
	public function ___uninstall() {
		// Example of dropping a DB table:  
		// you may remove this method if you do not need it
		try {
			$this->wire()->database->exec("DROP TABLE hello_world");
		} catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

		
}
