{: title :} Changelog
{: slug :} changelog
{: parent :} docs/apa-itu-pusaka
{: content :} ## v1.2.0 Beta Release

In this version there are several changes on codes and folder structures.

## Changelog

- create *addons/modules/* folder so addon modules (non-core modules) can be placed here
- change folder name *www/shared_media/* to *www/public/*
- move some assets from pusakapanel and jakarta theme to special place in *www/public/vendor/*
- upgrade CodeIgniter to v3.0.0
- implement Responsive File Manager
- create automenu module in panel
- change get_theme_url() to theme_url()
- add vendor_url() function helper
- remove unnecessary assets
- change error template

---------

## v1.1.5 Beta Release

### Improvement

- Integration CodeIgniter v3.0rc
- Update HMVC for compatibility with CodeIgniter v3
- Integration Ion Auth module for authentication and modified for file based compatible
- Post and page content saving without exiting form

### Bugfixes

- convert parent page of deleted children page to file if it has no more children

### Update Changes

- default login are now username:admin@admin.com password:password
- index.php now placed in www/ folder

---------

## v1.1.4 Beta Release

### improvement

- add generate_pagenav function helper
- each page can now given permission for any role

### bugfixes

- weird response when move page level
- fix get_content_image function helper name

---------

## v1.1.3 Beta Release

### Enhancement

- Multisite now can act like a subfolder

### Bugfix

- placing attributes when calling plugin function

---------

## v1.1.2 Beta Release

- fix unload config pusaka :P

---------

## v1.1.1 Beta Release

### Bugfixes

- session now made for each site
- limit function called for plugin by create a plugin file
- checking 'localhost' as local domain is now configurable
- encrypt password stored
- make json file uncallable via http

---------

## v1.1.0 Beta Release

### Improvement

- Add new feature: Export to static HTML
- Add intro field in blog for glance

### Bugfix

- content in page and edit form shouldn't be parsed
- showing custom meta tag in head
- cleaning unnecessary function in some helper
- check if username file exist when log in

--------

##v1.0.0 Beta Release

The main features has been finished. Those are:

- Page and Post Management
- Theme Management
- Codeigniter HMVC ready
- Lex Template Engine
- Minimalist Admin Panel, with some main features:
- Page management
- Post management
- Navigation link management
- Settings form
- User management

*Important: This is beta release so it need some more bugfix until we sure there is no more bugs. This release is intended for testing and learning until the stable version is done.*

--------
