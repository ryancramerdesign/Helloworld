<?php

/**
 * ProcessWire 'Hello world' demonstration module
 *
 * Demonstrates the Module interface and how to add hooks.
 * This version of Helloworld requires ProcessWire 2.6.0 or newer.
 * 
 * Copyright [year] by [your name]
 * 
 * ProcessWire 2.x 
 * Copyright (C) 2015 by Ryan Cramer 
 * Licensed under GNU/GPL v2, see LICENSE.TXT
 * https://processwire.com
 * 
 * Below we use phpdoc syntax to identify the configurable properties
 * from our Helloworld.config.php file. This is optional, but may be
 * helpful if you are using an editor that recognizes phpdoc syntax.
 * These properties will be automatically populated to your module, regardless
 * of whether or not you mention them here. See the Helloworld.config.php file.
 * 
 * @property string $helloMessage The hello world message to display
 * @property int $useHello Whether or not our hello message is enabled
 *
 */

class Helloworld extends WireData implements Module {

	/**
	 * Initialize the module (optional)
	 *
	 * ProcessWire calls this when the module is loaded. For 'autoload' modules, this will be called
	 * before ProcessWire's API is ready. This is a good place to attach hooks.
	 *
	 */
	public function init() {

		// Add a hook after the $pages->save, to issue a notice every time a page is saved
		$this->pages->addHookAfter('save', $this, 'pageSaveHookExample'); 

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
		$this->addHookProperty('Page::hello_world', function($event) {
			// Note: you can access any PW API variable directly from the $event object,
			// as you can with most ProcessWire objects. Here we use it to access the
			// $user API variable. 
			$event->return = "Hello " . $event->user->name; 
		}); 
	
		// This last example displays a special hello message when the user is editing
		// the homepage only. 	
		$this->addHookBefore('ProcessPageEdit::execute', function($event) {
			$page = $event->object->getPage(); // getPage() is a method in ProcessPageEdit
			if($page->id == 1) {
				// user is editing the homepage
				$event->message("Hello {$event->user->name} - You are editing the homepage!");
			} else {
				// not the homepage, so we will stay silent
			}
		});
	}

	/**
	 * Called when ProcessWire's API is ready (optional)
	 * 
	 * This optional method is similar to that of init() except that it is called
	 * after the current $page has been determined a and the API is fully ready to use.
	 * Use this method instead of (or in addition to) the init() method if your initialization
	 * requires knowing what the current $this->page is. 
	 * 
	 */
	public function ready() {
		// We don't have anything to do here, so this is just here as an explanation placeholder.
		// You can remove this method if you don't need it. 
	}

	/**
	 * Hook after $pages->save() method 
	 * 
	 * Hooks into the $pages->save() method and displays a notice every time a page is saved.
	 * 
	 * @param HookEvent $event
	 *
	 */
	public function pageSaveHookExample($event) {
		
		// We ask for the first argument passed to the $pages->save($page) method, which is argument 0. 
		// If preferred, you can also ask for an argument by name, i.e. $event->arguments('page'); 
		
		$page = $event->arguments(0); 
		$this->message($this->helloMessage . " - You saved {$page->path}."); 
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
	public function pageRenderHookExample($event) {

		// The $event->object is always the object hooked to, in this case a Page object,
		// since the hook is to Page::render.
		$page = $event->object; 
		
		// we are only going to show this message if the user is allowed to edit the page
		// this makes this silly module a little more production site friendly, so we 
		// aren't messing up anything on the front end, except for you hopefully! 
		if(!$page->editable()) return;

		// We are going to insert our configurable helloMessage into the output,
		// but first we entity encode it for safety (to keep HTML out of it)
		$helloMessage = $this->wire('sanitizer')->entities($this->helloMessage);
		
		// if not in the admin, tell them they can click it to edit the page
		if($page->template != 'admin') $helloMessage .= "<br>Click here to edit this page";
		
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
	public function pageHelloHookExample($event) {
		
		// return our configurable hello message
		$event->return = $this->helloMessage;
		
		if($event->arguments(0)) {
			// if the method call had an argument, append it in the return value, just to
			// demonstrate how your hook methods can use arguments. 
			$event->return .= " - " . $event->arguments(0);
		}
	}

}
