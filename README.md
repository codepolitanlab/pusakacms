# PusakaCMS

Pusaka CMS is a file-based Content Management System built on top of CodeIgniter 3 Framework

[![Join the chat at https://gitter.im/nyankod/pusakacms](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nyankod/pusakacms?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Current version: 1.2.0b

## Features

- Built on top of [CodeIgniter v3](http://www.codeigniter.com/)
- HMVC ready using [CodeIgniter Modular Extension ](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc)
- File based content storage
- Version Control System (VCS) friendly
- Multisite
- Pages and posts management
- Theme system
- Template parser using [Lex Parser](https://github.com/pyrocms/lex)
- Export web contents to static HTML
- File manager using [Responsive File Manager](http://www.responsivefilemanager.com/)

## Quick Install

- Download Latest release [here](https://github.com/nyankod/pusakacms/releases)
- Create folder in your localhost, i.e. *pusaka/*
- Extract all PusakaCMS files to folder *pusaka/*
- Open you browser and call *http://localhost/pusaka/www/default/*
- To access admin panel, use URL *http://localhost/pusaka/www/default/panel/*
- login with default username: **admin@admin.com** and password: **password**
- If you are using linux/unix based OS, make sure to give PHP write access to folder *system/application/sessions/*, *sites/*, and *www/media/*. Typically you may use these command:

```
$ sudo chmod 775 system/application/sessions/ sites/ www/media/ -R
$ sudo chown :www-data system/application/sessions/ sites/ www/media/ -R
```

## Teams

- [Toni Haryanto](id.toniharyanto.net)
- [Kresna Galuh](http://www.kresnagaluh.com/)
- [Ahmad Oriza](https://id.linkedin.com/in/ahmadoriza)
