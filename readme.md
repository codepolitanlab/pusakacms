# Codeigniter Cross Modular Extensions - XHMVC

XHMVC v.1.4.4 (27/Jun/2013)

Cross Modular Extensions for Codeigniter allow to share modules, controllers, views and models with many applications.

XHMVC brings to you a standard Codeginiter core and a standard HMVC core (from Wiredesignz), allowing to share this core to multiple applications.
Also, you can share config parameters, helpers, libraries, languages, views, and modules !!. 

From version 1.4.1, you can extend from your module/controller to an existing common/module/controller.
From version 1.4.1, you can extend from your module/model to an existing common/module/model.

To view Wiredesignz HMVC and it's capabilities: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc

If you have an auth module, an e-commerce module, a template library, Why not to share the same files ? 
If you are developping a multi-site, be sure that you can share common procedures/libraries/helpers, this will be your key to take profit of all the development and to make it faster.
If you have an application, move it to common/modules, share it with multiple applications and each will allow own configurations.

## Composer enabled.

Now, you can add any composer package, in the base directory you will find composer.json and some examples loaded under demo4 application
Todo: Put XHMVC under packagist.


## How to Install

XHMVC is ready-to-go, you only need to extract to any directory under a document root of your choice.

Needed:  Apache (mod_rewrite enabled for a ready-to-go functionality) + PHP (5.3), extension php_pdo_sqlite required for some demos.

1) Extract all files under your web workspace (as configured in your Xampp/Wampp), extract, for example, as codeigniter-cross-modular-extensions-xhmvc

2) Browse demos as:  http://localhost/codeigniter-cross-modular-extensions-xhmvc/applications/demo/www

3) View how works XHMVC: http://localhost/codeigniter-cross-modular-extensions-xhmvc/applications/demo/www/user-guide 

Demo1 have a standard codeginiter tree without any controler/module/view, inherits all from common welcome module.

Demo2 have a mininal directory tree, only basic config and core. Inherits all from common.

Demo3 welcome module is a powered welcome module, with Zend Debug + Profiler + Language example + Core Session Storage + Activerecord Cache, installed under demo3/application/modules.

Demo4 welcome module show inheritance, how the application/module/welcome extends from common/module/welcome


Each 'demo' folder have it's own application folder and a document_root mount point (www directory)


## Easy to use

Works ok with Codeigniter 2.1.3 and HMVC 5.4.

XHMVC will be upgraded if any of those are upgraded


## Inheritance

Any application under applications folder can inherit from common folder. Try to go to http://localhost/codeigniter-cross-modular-extensions-xhmvc/applications/demo/www/welcome

The demo application doesn't have a 'welcome' module, neither 'welcome' controller, but you can view it, inherit from common/modules/welcome.

Also, you can have your own welcome module, only overridding some methods, or extending some methods.


## Install in a existing application

Remember that XHMVC comes with HMVC. You will not need MX directory or any reference to MX in your application. All MX files are installed under /common/thir_party/MX folder, and Core_*.php files load HMVC by default.

Copy /common folder from this code to your project. Example:

      My app in   /var/www/myapp/application
	  Copy common folder to /var/www/myapp
	  
Modify index.php to include COMMONPATH constant, as in the example code.

    define('COMMONPATH',dirname(__FILE__).'/../common/'); # Relative to index.php file
* Or wherever you instaled the COMMON folder

Modify config.php to include COMMONPATH in yout modules_locations config, as in the example code.

    $config['modules_locations'] = array(
        APPPATH.'modules/' => '../modules/',
        COMMONPATH.'modules/' => '../'.COMMONPATH.'modules/',
    );


Modify your /application/core/MY_* to extend from Core

/application/core/MY_Controller.php:

    <?php
        require_once COMMONPATH.'core/Core_Controller.php';
        class MY_Controller extends Core_Controller{
          // Your existing methods here
        }

/application/core/MY_Loader.php:

    <?php
        require_once COMMONPATH.'core/Core_Loader.php';
        class MY_Loader extends Core_Loader {
          // Your existing methods here
        }

/application/core/MY_Model.php:

    <?php
        require_once COMMONPATH.'core/Core_Model.php';
        class MY_Model extends Core_Model {
          // Your existing methods here
        }

/application/core/MY_Router.php:

    <?php
        require_once COMMONPATH."core/Core_Router.php";
        class MY_Router extends Core_Router {
          // Your existing methods here
        }


###Optional: 

// Use xhmvc session wrapper
/application/core/MY_Session.php

    <?php
        require_once COMMONPATH.'core/Core_Session.php';
        class MY_Session extends Core_Session {}

// Use extended profiler
/application/libraries/MY_Profiler.php

    <?php
        require_once COMMONPATH.'core/Core_Profiler.php';
        class MY_Profiler extends Core_Profiler{}
// To enable extended profiler log, add this to yur config.php:  $config['log_profiler'] = TRUE;


## Sharing and reuse

All libraries, helpers, modules and third_party programs can be shared between any codeigniter application. 
This is usefull to re-use common programs and to have a central repository instead of have a lot of copies of the same code.

## Sharing System (Codeigniter Core)

Modify index.php to define system_path (or BASEPATH constant) accordingly to your system folder:

    $system_path = '../core/system';

Remmeber that you can put your system folder wherever you want, any application in same server can share the same system folder.


## Sharing a module

Move module directory module under /common/modules

Remember that any existing module under your application/modules folder will have priority over same module in common/modules folder

## Sharing a library

Move library to /common/libraries

Remember that any existing library under your application/libraries folder will have priority over same module in common/libraries folder

## Sharing a helper

Move helper to /common/helpers

Remember that any existing helper under your application/helpers folder will have priority over same helper in common/helpers folder

## Sharing a package

Move package file or directory to /common/thir_party

Remember that any existing package file under your application/third_party folder will have priority over same package in common/third_party folder

## Sharing a config file

Move config file to /common/config

Remember that any existing config file under your application/config folder will have priority over same helper in common/config folder
