{: btnSaveExit :} 1
{: title :} Changelog
{: slug :} changelog
{: content :} <h2>v1.2.0 Beta Release</h2>

<p>In this version there are several changes on codes and folder structures.</p>

<h2>Changelog</h2>

<ul>
	<li>create <em>addons/modules/</em> folder so addon modules (non-core modules) can be placed here</li>
	<li>change folder name <em>www/shared_media/</em> to <em>www/public/</em></li>
	<li>move some assets from pusakapanel and jakarta theme to special place in <em>www/public/vendor/</em></li>
	<li>upgrade CodeIgniter to v3.0.0</li>
	<li>implement Responsive File Manager</li>
	<li>create automenu module in panel</li>
	<li>change get_theme_url() to theme_url()</li>
	<li>add vendor_url() function helper</li>
	<li>remove unnecessary assets</li>
	<li>change error template</li>
</ul>

<hr />
<h2>v1.1.5 Beta Release</h2>

<h3>Improvement</h3>

<ul>
	<li>Integration CodeIgniter v3.0rc</li>
	<li>Update HMVC for compatibility with CodeIgniter v3</li>
	<li>Integration Ion Auth module for authentication and modified for file based compatible</li>
	<li>Post and page content saving without exiting form</li>
</ul>

<h3>Bugfixes</h3>

<ul>
	<li>convert parent page of deleted children page to file if it has no more children</li>
</ul>

<h3>Update Changes</h3>

<ul>
	<li>default login are now username:admin@admin.com password:password</li>
	<li>index.php now placed in www/ folder</li>
</ul>

<hr />
<h2>v1.1.4 Beta Release</h2>

<h3>improvement</h3>

<ul>
	<li>add generate_pagenav function helper</li>
	<li>each page can now given permission for any role</li>
</ul>

<h3>bugfixes</h3>

<ul>
	<li>weird response when move page level</li>
	<li>fix get_content_image function helper name</li>
</ul>

<hr />
<h2>v1.1.3 Beta Release</h2>

<h3>Enhancement</h3>

<ul>
	<li>Multisite now can act like a subfolder</li>
</ul>

<h3>Bugfix</h3>

<ul>
	<li>placing attributes when calling plugin function</li>
</ul>

<hr />
<h2>v1.1.2 Beta Release</h2>

<ul>
	<li>fix unload config pusaka :P</li>
</ul>

<hr />
<h2>v1.1.1 Beta Release</h2>

<h3>Bugfixes</h3>

<ul>
	<li>session now made for each site</li>
	<li>limit function called for plugin by create a plugin file</li>
	<li>checking &#39;localhost&#39; as local domain is now configurable</li>
	<li>encrypt password stored</li>
	<li>make json file uncallable via http</li>
</ul>

<hr />
<h2>v1.1.0 Beta Release</h2>

<h3>Improvement</h3>

<ul>
	<li>Add new feature: Export to static HTML</li>
	<li>Add intro field in blog for glance</li>
</ul>

<h3>Bugfix</h3>

<ul>
	<li>content in page and edit form shouldn&#39;t be parsed</li>
	<li>showing custom meta tag in head</li>
	<li>cleaning unnecessary function in some helper</li>
	<li>check if username file exist when log in</li>
</ul>

<hr />
<h2>v1.0.0 Beta Release</h2>

<p>The main features has been finished. Those are:</p>

<ul>
	<li>Page and Post Management</li>
	<li>Theme Management</li>
	<li>Codeigniter HMVC ready</li>
	<li>Lex Template Engine</li>
	<li>Minimalist Admin Panel, with some main features:</li>
	<li>Page management</li>
	<li>Post management</li>
	<li>Navigation link management</li>
	<li>Settings form</li>
	<li>User management</li>
</ul>

<p><em>Important: This is beta release so it need some more bugfix until we sure there is no more bugs. This release is intended for testing and learning until the stable version is done.</em></p>

<hr />
{: layout :} _docs
