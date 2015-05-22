# ProcessWire 'Hello world' demonstration module

Demonstrates the Module interface and how to add hooks.
This version of Helloworld requires ProcessWire 2.6.0 or newer.
This can also serve as a starting point for building your own modules.


## What this module does

Everything that this module does is purely for demonstration purposes.
It doesn't do anything particularly useful, but reveals a lot about 
what you can do with modules and hooks. Here's what it does: 

- Adds a hook after Page::render to output a hello world message at the 
  bottom of editable pages (if enabled in the module configuration). 
  Just to make it somewhat useful, clicking it takes you to the editor
  for that page. 
  
- Adds a hook after Pages::save to display a hello notification every 
  time you save a page. 
  
- Adds a `$page->hello()` method to all pages, which simply returns your
  hello world message and information about the page. Optionally provide
  an argument with some text, i.e. `$page->hello('some text')` to have it
  included in the return value. 
  
- Adds a `$page->hello_world` property to all pages. Accessing it simply
  returns "Hello [your-user-name]". 
  
- Adds a ProcessPageEdit::execute hook, which displays a notification to
  you only when you edit the homepage. 
  

## How to test this module

1. Install the module from your admin (Modules > Site > Hello World).

2. Configure the module.

3. After testing it, look at the code and read the comments. At this point you may
   want play with it and modify it to do something useful. 


## How to use this to make your own module

To see exactly what this module does, you may want to install it as-is first. 
Then uninstall and follow the instructions below. 

1. Rename the directory and all files, replacing "Helloworld" with the name of your module.

2. Change the class name in the module file to be [YourModuleName]. This should be the same
   name that you used for your module file (minus the ".module.php" part). 

3. Modify the code of the module to do what you want. You can simply remove all of the 
   methods in it, though you may wish to leave these method definitions in place:
   init() and/or ready(), ___install(), ___uninstall().

4. Edit the [YourModuleName].info.php file to contain info specific to your module. 

5. If you want your module to be configurable, edit the [YourModuleName].config.php
   file, update the configuration as needed. If you do not need a configurable module, 
   simply remove the file. 

7. Update this README.md file to contain information specific to your module. 

8. When you've got something you'd like to share, post your module to GitHub and to 
   modules.processwire.com!
   

Stop by the [ProcessWire forums](http://processwire.com/talk/) anytime and we will be glad 
to help with any questions. 

------
[ProcessWire](http://processwire.com) Copyright 2015 by Ryan Cramer

