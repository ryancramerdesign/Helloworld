# ProcessWire 'Hello world' demonstration module

This module does a lot of useless stuff purely for demonstration purposes.
It serves as a good intro to module development in ProcessWire.

Please note this is completely different from the Helloworld module
that comes with ProcessWire’s core. You’ll want to replace that one
with this one. 
 
  
## To install 

Replace the `/site/modules/Helloworld/` files that come with the core
with the files from this module. In your admin, go to Modules > Refresh.
Then click “install” for the “Hello World” module (on the Site tab). 


## What this module does

Everything that this module does is purely for demonstration purposes.
It doesn’t do anything particularly useful, but reveals a lot about 
what you can do with modules and hooks. Specifically:

- Adds a hook after `Page::render` to output a hello world message at the 
  bottom of editable pages (if enabled in the module configuration). 
  Just to make it somewhat useful, clicking it takes you to the editor
  for that page. 
  
- Adds a hook after `Pages::save` to display a hello notification every 
  time you save a page. 
  
- Adds a `$page->hello()` method to all pages, which simply returns your
  hello world message and information about the page. Optionally provide
  an argument with some text, i.e. `$page->hello('some text')` to have it
  included in the return value. 
  
- Adds a `$page->hello_world` property to all pages. Accessing it simply
  returns: “Hello user-name”.
  
- Adds a `ProcessPageEdit::execute` hook which displays a notification to
  you only when you edit the homepage. 

- Demonstrates the optional `install()`, `uninstall()` and `upgrade()` 
  methods. The install method creates database table `hello_world`, while
  the uninstall method removes it. The upgrade method congratulates the 
  user when they upgrade from version 0.0.3 or prior. 
  
- ProcessWire 3.0.173 and newer: Demonstrates
  [URL/path hooks](https://processwire.com/blog/posts/pw-3.0.173/).
  Try accessing these URLs on your site: 
  
  - `/hello/world/` - URL hook 1: answers only this URL
  - `/hello/planet/mars` - URL hook 2: allows earth, mars or jupiter
  - `/hello/anything/` - URL hook 3: replace 'anything' with any word
 
- ProcessWire 3.0.181 and newer: Demonstrates inclusion of language 
  translations with the module. Requires that ProcessWire’s core multi-
  language support modules are installed. Language translation files are
  .csv files exported from ProcessWire’s language translator tools that
  are stored in a /languages/ directory of of your module’s directory.
 
  
## How to explore and test this module

1. Install the module from your admin (Modules > Site > Hello World).

2. Configure the module in the admin and Save.

3. Look at the code and read the comments in the module file. The comments
   and examples in the module are the point of this module, so step through
   and test them one by one and test where interested.

   
## How to use this to make your own module

To see exactly what this module does, you may want to install it as-is first. 
Then uninstall and follow the instructions below. 

1. Rename the directory and all files, replacing `Helloworld` with the name of your module.

2. Change the class name in the module file to be `ModuleName` (replacing with your module
   name that you want to use). This should be the same name that you used for your module 
   file (minus the ".module.php" part). 

3. Modify the code of the module to do what you want. You can simply remove all of the 
   methods in it or you may wish to leave these method definitions in place:
  
   - `__construct()` if you want to set defaults for a configurable module.  
   - `init()` for module initialization or attaching hooks. 
   - `ready()` if an “autoload” module requires knowing the current `$page` API var.
   - `install()` to handle module installation and/or requirements verification.
   - `uninstall()` to undo whatever the install method did. 
   - `getModuleConfigInputfields()` if you want to have a configurable module. 

4. Rename the `Helloworld.info.php` file to `ModuleName.info.php` and update the 
   values in the file to be specific for your module. 

5. If you DO want your module to be configurable, do ONE of the following: 

   - **Option A: Use a getModuleConfigInputfields() method in the module:**   
     Edit the `getModuleConfigInputfields()` method at the bottom of the `.module` file
     and update as needed for your configuration. Update the `__construct()` method 
     to set your default configuration values. Update the phpdoc comments at the top
     of the `.module` file to provide documentation for your configurable settings.

   - **Option B: Use an external ModuleName.config.php file:**   
     Copy the `extras/Helloworld.config.php` file to `ModuleName.config.php` (placing
     it in the same directory as your module) and update the file as needed. Remove the 
     `getModuleConfigInputfields()` method from the `.module` file. You may also remove 
     the setting of default configuration values from the `__construct()` method, as
     ProcessWire will handle this for you when using an external configuration file.
     Optionally add phpdoc comments at the top of the `.module` file to provide 
     documentation for your configurable settings. 

6. If you DO NOT want a configurable module, do the following:    

   - Remove the `Helloworld.config.php` file. 
   - Remove the `getModuleConfigInputfields()` method from the .module file. 
   - Remove the `ConfigurableModule` interface from the top of the .module file. 
   - Remove the setting of default configuration values from the `__construct()` method. 
   - Remove any phpdoc comments documenting config settings in the `.module` file.

7. Update/replace this `README.md` file to contain information specific to your module. 

8. If you want to include translations for other languages with your module, see the
   next section in this file: “Bundling multi-language translations with your module.”
   If you do not want to bundle language translations then you can remove the 
   `/languages/` directory. 
   
9. Remove the `/extras/` directory included with this module, as it is just examples
   and your module will not need it.    
   
When you’ve got something you'd like to share, post your module to GitHub and to 
the ProcessWire modules directory at: <https://processwire.com/modules/>


## Bundling multi-language translations with your module   

This requires ProcessWire 3.0.181+ and that you have multi-language support installed.

- Locate the files you want to translate from your admin: Setup > Languages > 
  language > Site files > Find files to translate. Select the file(s) and submit. 
  ProcessWire will generate new empty `.json` files for the files you selected to 
  translate. 
  
- In Setup > Languages > language, click the "edit" link for file(s) added for 
  your module. Translate the text into the desired language and save. Near the top 
  of the translation screen is a link to "Download a CSV file". Click that to save
  the CSV file of translations. 
  
- Copy the CSV file(s) you downloaded in the previous step into a `/languages/` 
  directory in your module’s path. For instance `/site/modules/Helloworld/languages/`
  is the one you'll see with this module. While not required, I recommend naming 
  your files with the ISO-639-1 language code. For instance, German would be 
  `de.csv`, Spanish would be `es.csv`, Finnish would be `fi.csv`, etc. 

- If your module has multiple translatable files, you can bundle all the translations
  into a single CSV file (just copy and paste into one), or you can have multiple
  `.csv` files for each language. For instance, if this module had both 
  `Helloworld.module` and `ProcessHelloworld.module` files, we might choose to name our 
  csv files `es-main.csv` and `es-process.csv`. Or we could just have an `es.csv` 
  file that merges that translations from both of them. 

- In your module’s documentation, instruct the user to install translations from 
  your module’s info/config screen. It’s in the “Module Information” fieldset 
  “Languages” row, where there is an “install translations” link. When new versions
  of your module also update the translations, make note of that in your changelog
  so that users will know to click the “install translations” again to update
  the translations. 
  

Stop by the [ProcessWire forums](http://processwire.com/talk/) anytime and we will be glad 
to help with any questions. 

## Other ProcessWire demo modules by Ryan:

- Process module demonstration: <https://processwire.com/modules/process-hello/>
- Fieldtype and Inputfield module demonstration: <https://processwire.com/modules/fieldtype-events/>

------
[ProcessWire](http://processwire.com) Copyright 2021 by Ryan Cramer

