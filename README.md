# ProcessWire 'Hello world' demonstration module

- Demonstrates the Module interface and how to add hooks.
- This version of Helloworld requires ProcessWire 3.x.
- This can also serve as a starting point for building your own modules.
- Please note this is completely different from the HelloWorld module
  that comes with ProcessWire’s core. 
  
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
  returns:
  
  > Hello user-name
  
- Adds a `ProcessPageEdit::execute` hook which displays a notification to
  you only when you edit the homepage. 
  
- ProcessWire 3.0.173 and newer: Demonstrates
  [URL/path hooks](https://processwire.com/blog/posts/pw-3.0.173/).
  Try accessing the `/hello/world/` URL on your site. 
 
- ProcessWire 3.0.181 and newer: Demonstrates inclusion of language 
  translations with the module. Requires that ProcessWire’s core multi-
  language support modules are installed. Language translation files are
  .csv files exported from ProcessWire’s language translator tools that
  are stored in a /languages/ directory of of your module’s directory.
  
## How to test this module

1. Install the module from your admin (Modules > Site > Hello World).

2. Configure the module.

3. After testing it, look at the code and read the comments. At this point you may
   want play with it and modify it to do something useful. 

   
## How to use this to make your own module

To see exactly what this module does, you may want to install it as-is first. 
Then uninstall and follow the instructions below. 

1. Rename the directory and all files, replacing `Helloworld` with the name of your module.

2. Change the class name in the module file to be `ModuleName` (replacing with your module
   name that you want to use). This should be the same name that you used for your module 
   file (minus the ".module.php" part). 

3. Modify the code of the module to do what you want. You can simply remove all of the 
   methods in it, though you may wish to leave these method definitions in place:
   
   - `init()` and/or `ready()` 
   - `___install()` and `___uninstall()` 
   - `getModuleConfigInputfields()` if you want to have a configurable module. 

4. Edit the `ModuleName.info.php` file to contain info specific to your module. 

5. If you DO want your module to be configurable, do one of the following: 

   A. Edit the `getModuleConfigInputfields()` method at the bottom of the .module file
      and update as needed for your configuration. Update the `__construct()` method 
      to set your default configuration values. Update the phpdoc comments at the top
      of the `.module` file to provide documentation for your configurable settings.

   B. To use an external configuration file instead: 
      Rename the `Helloworld-example.config.php` file to `ModuleName.config.php`
      and update the file as needed. Remove the `getModuleConfigInputfields()` method
      from the `.module` file. You may also remove the setting of default configuration
      values from the `__construct()` method.  

6. If you DO NOT want a configurable module, do the following:    

   - Remove the `Helloworld.config.php` file. 
   - Remove the `getModuleConfigInputfields()` method from the .module file. 
   - Remove the `ConfigurableModule` interface from the top of the .module file. 
   - Remove the setting of default configuration values from the `__construct()` method. 

7. Update/replace this `README.md` file to contain information specific to your module. 

8. If you want to include translations for other languages with your module, see the
   next section in this file: “Bundling multi-language translations with your module.”
   
9. When you've got something you'd like to share, post your module to GitHub and to 
   <https://processwire.com/modules/>


## Bundling multi-language translations with your module   

This requires ProcessWire 3.0.181+ and that you have multi-language support installed.

- Locate the files you want to translate from your admin: Setup > Languages > 
  language > Site files > Find files to translate. Select the file(s) and submit. 
  ProcessWire will generate new empty `.json` files for the files you selected to 
  translate. 
  
- In Setup > Languages > language, click the "edit" link for file(s) added for 
  your module. Translate the text into the desired language and save. Near the top 
  of the translation screen is a link to "Download a CSV file" Click that to save
  the CSV file of translations. 
  
- Copy the CSV file(s) you downloaded in the previous step into a `/languages/` 
  directory in your module directory. For instance `/site/modules/Helloworld/languages/`
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

