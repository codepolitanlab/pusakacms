<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*/


//shared items across the entire app
$lang['alternative_page_title'] = "Site Builder Lite";
$lang['newsite_default_title'] = "My New Site";
$lang['modal_close'] = "Close";
$lang['modal_areyousure'] = "Are you sure?";
$lang['modal_cancelclose'] = "Cancel & Close";
$lang['modal_delete'] = "Delete";
$lang['back'] = "back";
$lang['cancel'] = "Cancel";
$lang['imsure'] = "Yes, I'm sure";

$lang['loading_site_data'] = "Loading site data...";
$lang['loading_saving_data'] = "Saving data...";


// view/shared/nav.php
$lang['nav_toggle_navigation'] = "Toggle Navigation";
$lang['nav_name'] = "<b class='text-primary'>SITE</b>BUILDER";
$lang['nav_sites'] = "Sites";
$lang['nav_imagelibrary'] = "Image Library";
$lang['nav_users'] = "Users";
$lang['nav_settings'] = "Settings";
$lang['nav_myaccount'] = "My Account";
$lang['nav_logout'] = "Logout";
$lang['nav_goback_sites'] = "Back to Sites";
$lang['nav_goback_users'] = "Back to Users";


// views/auth/login.php
$lang['login_page_title'] = "Login | Site Builder Lite";


//sites/sites.php
$lang['sites_page_title'] = "Sites | Site Builder Lite";
$lang['sites_header'] = "Sites";
$lang['sites_createnewsite'] = "Create New Site";
$lang['sites_filterbyuser'] = "Filter By User";
$lang['sites_filterbyuserall'] = "All";

$lang['sites_sortby'] = "Sory by";
$lang['sites_sortby_creationdate'] = "Creation date";
$lang['sites_sortby_lastupdated'] = "Last updated";
$lang['sites_sortby_numberofpages'] = "Number of pages";

$lang['sites_details_owner'] = "Owner";
$lang['sites_details_pages'] = "Page(s)";
$lang['sites_details_createdon'] = "Created on";
$lang['sites_details_lasteditedon'] = "Last edited on";

$lang['sites_empty_placeholder'] = "This site is empty";

$lang['sites_sitehasnotbeenpublished'] = "Site has not been published";
$lang['sites_button_publishnow'] = "Publish Now";

$lang['sites_button_editthissite'] = "Edit This Site";
$lang['sites_button_settings'] = "Settings";
$lang['sites_button_delete'] = "Delete";

$lang['sites_deletesite_loadertext'] = 'Deleting site...';
$lang['sites_deletesite_areyousure'] = "Are you sure you want to delete this site?";
$lang['sites_deletesite_button_deleteforever'] = "Delete Forever";

$lang['sites_nosites_heading'] = "Well, hello there!";
$lang['sites_nosites_message'] = "It appears you might be new around these parts. At the moment, you don't have any sites to call your own just yet, so why not get started and build yourself one awesome little website?";
$lang['sites_nosites_button_confirm'] = "Yes, I want to build a website!";
$lang['sites_nosites_button_cancel'] = "Nah, maybe later";


// views/shared/modal_account.php
$lang['account_myaccount'] = "My Account";
$lang['account_tab_account'] = "Account";
$lang['account_tab_settings'] = "Settings";

$lang['account_label_first_name'] = "First name";
$lang['account_label_last_name'] = "Last name";
$lang['account_button_updatedetails'] = "Update Details";
$lang['account_label_username'] = "Username";
$lang['account_label_password'] = "Password";



// views/shared/modal_sitesettings.php
$lang['sitesettings_sitesettings'] = "Site Settings";
$lang['sitesettings_button_savesettings'] = "Save Settings";


// views/partials/sitedata.php
$lang['sitedata_sitedetails'] = "Site details";

$lang['sitedata_label_name'] = "Site name";

$lang['sitedata_publishingdetails'] = "Publishing details";

$lang['sitedata_label_publicurl'] = "Public URL";
$lang['sitedata_label_publicurl_placeholder'] = "Public URL, ie http://mysite.com";
$lang['sitedata_label_ftpserver'] = "FTP Server";
$lang['sitedata_label_ftpuser'] = "FTP User";
$lang['sitedata_label_ftppassword'] = "FTP Password";
$lang['sitedata_label_ftpport'] = "FTP Port";
$lang['sitedata_label_ftpport_placeholder'] = "21";
$lang['sitedata_label_ftppath'] = "FTP Path";
$lang['sitedata_button_browseserver'] = "Browse Server";

$lang['sitedata_connectingtoftp'] = "connecting to ftp ...";

$lang['sitedata_button_testftpconnection'] = "Test FTP Connection";

$lang['sitedata_testingftpconnection'] = "Testing FTP Connection ...";


// views/partials/ftplist.php
$lang['ftplist_uponelevel'] = "Up one level";


// views/sites/create.php
$lang['elements_heading'] = "Blocks";
$lang['all_elements'] = "All Blocks";
$lang['pages'] = "Pages";

$lang['button_add_page'] = "Add Page";
$lang['button_publish_page'] = "Publish";

$lang['actionbuttons_sitesettings'] = "Site Settings";
$lang['actionbuttons_pagesettings'] = "Page Settings";
$lang['actionbuttons_save'] = "Save";
$lang['actionbuttons_export'] = "Export";
$lang['actionbuttons_publish'] = "Publish";

$lang['label_building_mode'] = "Building Mode";
$lang['label_building_mode_elements'] = "Blocks";
$lang['label_building_mode_content'] = "Content";
$lang['label_building_mode_details'] = "Details";

$lang['mode_tooltip_elements'] = "Allows you to add, remove and re-order blocks on the canvas. You can also view and edit the block's source HTML";
$lang['mode_tooltip_content'] = "Allows you to edit written conten on your pages. Editable elements will display a red dashed outline when hovering the mouse cursor over it.";
$lang['mode_tooltip_styling'] = "Allows you edit certain style attributes, images, links and videos. Editable Elements will display a red dashed outline when hovering the cursor over it.";

$lang['canvas_empty'] = "Build your page by dragging blocks onto the canvas";

$lang['detail_editor_heading'] = "Detail Editor";
$lang['detail_editor_label_editing'] = "editing";
$lang['detail_editor_tab_style'] = "Style";
$lang['detail_editor_tab_link'] = "Link";
$lang['detail_editor_tab_image'] = "Image";
$lang['detail_editor_tab_icons'] = "Icons";
$lang['detail_editor_tab_video'] = "Video";

$lang['enter_youtube_id'] = "Youtube Video ID";
$lang['enter_vimeo_id'] = "Vimeo Video ID";

$lang['choose_a_page'] = "Choose a page";
$lang['choose_a_block'] = "Choose a block (one page sites)";

$lang['OR'] = "OR";

$lang['enter_image_path'] = "Enter image path";
$lang['upload_image'] = "Upload image";
$lang['select_image'] = "Select image";
$lang['change'] = "Change";
$lang['remove'] = "Remove";
$lang['open_image_library'] = "Open image library";

$lang['choose_an_icon'] = "Choose an icon below";

$lang['the_changes_were_applied'] = "The changes were applied successfully!";

$lang['sidebuttons_apply_changes'] = "Apply changes";
$lang['sidebuttons_apply_clone'] = "Clone";
$lang['sidebuttons_apply_reset'] = "Reset";
$lang['sidebuttons_apply_remove'] = "Remove";

$lang['modalexport_export_your_markup'] = "Export your markup";
$lang['modalexport_doctype'] = "Doc type";
$lang['modalexport_export_now'] = "Export Now";

$lang['modaldeleteblock_areyousure'] = "Are you sure you want to delete this block?";

$lang['modalpublish_publishyoursite'] = "Publish your site";

$lang['modalpublish_success_heading'] = "Hooray!";
$lang['modalpublish_success_message'] = "Publishing has finished and all your selected pages and/or assets were successfully published.";

$lang['modalpublish_pendingchanges_heading'] = "You have pending changes";
$lang['modalpublish_pendingchanges_message'] = "It appears the latest changes to this site have not been saved yet. Before you can publish this site, you will need to save the last changes.";
$lang['modalpublish_pendingchanges_button_savechanges'] = "Save Changes";

$lang['modalpublish_siteassets'] = "Site assets";
$lang['modalpublish_asset'] = "Asset";

$lang['modalpublish_publishing'] = "Publishing...";
$lang['modalpublish_published'] = "Published";

$lang['modalpublish_sitepages'] = "Site pages";
$lang['modalpublish_page'] = "Page";

$lang['modalpublish_publish_now'] = "Publish Now";

$lang['modalresetblock_areyousure'] = "Are you sure you want to reset this block?";
$lang['modalresetblock_message'] = "All changes made to the content will be destroyed.";
$lang['modalresetblock_button_reset'] = "Reset Block";

$lang['modaldeletepage_areyousure'] = "Are you sure you want to delete this entire page?";
$lang['modaldeletepage_button_deletepage'] = "Delete Page";

$lang['modaldeleteelement_areyousure'] = "Are you sure you want to delete this block? Once deleted, it can not be restored.";
$lang['modaldeleteelement_button_deleteelement'] = "Delete Block";

$lang['sites_loading'] = "Loading Builder...";

$lang['modal_pendingchanges_areyousure'] = "You've got pending changes, if you leave this page your changes will be lost. Are you sure?";
$lang['modal_pendingchanges_button_stay'] = "Stay on this page!";
$lang['modal_pendingchanges_button_leave'] = "Leave the page";

$lang['modal_editcontent_updatecontent'] = "Update Content";

$lang['modal_imagelibrary_heading'] = "Image Library";
$lang['modal_imagelibrary_loadertext'] = "Uploading image...";
$lang['modal_imagelibrary_tab_myimages'] = "My Images";
$lang['modal_imagelibrary_tab_uploadimage'] = "Upload Image";
$lang['modal_imagelibrary_tab_otherimages'] = "Other Images";
$lang['modal_imagelibrary_message_noimages'] = "You currently have no images uploaded. To upload images, please use the upload panel on your left.";
$lang['modal_imagelibrary_button_selectimage'] = "Select Image";
$lang['modal_imagelibrary_button_change'] = "Change";
$lang['modal_imagelibrary_button_remove'] = "Remove";
$lang['modal_imagelibrary_button_upload'] = "Upload Image";
$lang['modal_imagelibrary_ribbon_admin'] = "Admin";
$lang['modal_imagelibrary_button_insert'] = "Insert Image";
$lang['modal_imagelibrary_button_insertimage'] = "Insert Image";

$lang['modal_pagesettings_header'] = "Page Settings for";
$lang['modal_pagesettings_loadertext'] = "Saving page settings...";


// views/partials/pagedata.php
$lang['modal_pagesettings_pagetitle'] = "Page Title";
$lang['modal_pagesettings_pagedescription'] = "Page Meta Description";
$lang['modal_pagesettings_pagekeywords'] = "Page Meta Keywords";
$lang['modal_pagesettings_pageheaderincludes'] = "Header Includes";



// views/assets/images.php
$lang['images_heading'] = "My Image Library";
$lang['images_uploadimages'] = "Upload Image(s)";
$lang['images_button_selectimage'] = "Select Image";
$lang['images_button_change'] = "Change";
$lang['images_button_remove'] = "Remove";
$lang['images_button_upload'] = "Upload Image";

$lang['images_error_heading'] = "Ouch! Something went wrong";
$lang['images_success_heading'] = "Success!";
$lang['images_success_message'] = "Your image was uploaded successfully!";

$lang['images_tab_myimages'] = "My Images";
$lang['images_tab_otherimages'] = "Other Images";

$lang['images_button_view'] = "view";
$lang['images_button_delete'] = "delete";

$lang['images_message_noimages'] = "You currently have no images uploaded. To upload images, please use the upload panel on your left.";
$lang['images_label_admin'] = "Admin";

$lang['modal_deleteimage_message'] = "Deleting this image is permanent and <b>can not be undone</b>. Are you sure you want to continue?";
$lang['modal_deleteimage_button_delete'] = "Permanently delete image";


// views/auth/login.php
$lang['login_sitetitle'] = "<b>SITE</b>BUILDER";
$lang['login_rememberme'] = "Remember me";
$lang['login_button_login'] = "Log me in";
$lang['login_lostpassword'] = "Lost your password?";



// views/settings/settings.php
$lang['settings_heading'] = "Settings";

$lang['settings_tab_applicationsettings'] = "Application Settings";

$lang['settings_warning_heading'] = "Be careful please!";
$lang['settings_warning_message'] = "Please be cautious when making changes to the settings below. Unless you know what you're doing, don't make changes to any of these.";

$lang['settings_requiredfields'] = "* required fields, can not be empty!";
$lang['settings_button_update'] = "Update Settings";

$lang['settings_confighelp_heading'] = "Config help";
$lang['settings_confighelp_message'] = "Click any of the setting boxes will display details about that setting in this box here :)";


// views/users/users.php
$lang['users_heading'] = "Users";

$lang['users_button_addnew'] = "Add New User";

$lang['users_tab_account'] = "Account";
$lang['users_tab_sites'] = "Sites";

$lang['users_nosites'] = "This user has not created any sites yet.";

$lang['users_button_edit'] = "Edit";
$lang['users_button_settings'] = "Settings";
$lang['users_button_delete'] = "Delete";

$lang['users_emailfield_placeholder'] = "Email address";
$lang['users_emailfield_password'] = "Password";
$lang['users_adminpermissions'] = "Admin permissions";
$lang['users_button_udpate'] = "Update Details";

$lang['users_button_sendpasswordreset'] = "Send Password Reset Email";
$lang['users_button_deleteaccount'] = "Delete Entire Account";

$lang['users_modal_deleteuser_message'] = "Deleting this user account will result in all associated data being deleted (with the exception of externally published sites) and <b>can not be undone</b>. Are you sure you want to continue?";

$lang['users_modal_newuser_heading'] = "Create a new user account";
$lang['users_modal_newuser_loadertext'] = "Creating new account...";
$lang['users_modal_newuser_firstname'] = "First name";
$lang['users_modal_newuser_lastname'] = "Last name";
$lang['users_modal_newuser_email'] = "Email";
$lang['users_modal_newuser_password'] = "Password";
$lang['users_modal_newuser_adminpermissions'] = "Admin permissions";
$lang['users_modal_newuser_sendnotification'] = "Send notification";
$lang['users_modal_newuser_button_create'] = "Create Account";



// controllers/assets.php -> imageUploadAjax()
$lang['assets_imageUploadAjax_error1_heading'] = "Ouch! Something went wrong:";
$lang['assets_imageUploadAjax_error1_message'] = "Something went wrong when trying to upload your image, please see the details below:<br>";

$lang['assets_imageUploadAjax_success_heading'] = "All set!";
$lang['assets_imageUploadAjax_success_message'] = "Your image was uploaded successfully and can now be found under the 'My Images' tab.";


// controllers/configuration.php -> connect()
$lang['assets_update_error'] = "There were some issues with your data and we could not save your data right now, please see the details below:<br><br>";
$lang['assets_update_success'] = "Your settings were saved successfully!";


// controllers/ftpconnection.php -> update()
$lang['ftpconnecton_connect_error1_heading'] = "Error:";
$lang['ftpconnecton_connect_error1_message'] = "The path you have provided is not correct or you might not have the required permissions to access this path.";

$lang['ftpconnecton_connect_error2_heading'] = "Error:";
$lang['ftpconnecton_connect_error2_message'] = "The connection details you provided are not correct. Please update the details and try again";


// controllers/ftpconnection.php -> test()
$lang['ftpconnection_test_success_heading'] = "All good!";
$lang['ftpconnection_test_success_message'] = "The provided FTP details are all good and can be used to publish this site.";

$lang['ftpconnection_test_error1_heading'] = "Error:";
$lang['ftpconnection_test_error1_message'] = "The connection details (server, username, password and/or port) you provided are not correct. Please update the details and try again.";

$lang['ftpconnection_test_error2_heading'] = "Error:";
$lang['ftpconnection_test_error2_message'] = "The path you have provided is not correct or you might not have the required permissions to access this path.";



// controllers/sites.php -> save()
$lang['sites_save_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_save_error1_message'] = "The site name is missing from your data. Please reload the Builder and try again.";

$lang['sites_save_error2_heading'] = "Ouch! Something went wrong:";
$lang['sites_save_error2_message'] = "It appears all page data is missing. Please reload the Builder and try again.";

$lang['sites_save_success1_heading'] = "Success!";
$lang['sites_save_success1_message'] = "The site has been saved successfully!";

$lang['sites_save_success2_heading'] = "Success!";
$lang['sites_save_success2_message'] = "The site has been saved successfully!";

$lang['sites_save_success3_heading'] = "Success!";
$lang['sites_save_success3_message'] = "The site has been saved successfully! You can now proceed with publishing your site.";

// controllers/sites.php -> site()
$lang['sites_site_error1'] = "The site you're trying to load does not exist.";

// controllers/sites.php -> siteAjax()
$lang['sites_siteAjax_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_siteAjax_error1_message'] = "It appears the site ID is missing. Please refresh your page and try again.";

$lang['sites_siteAjax_error2_heading'] = "Ouch! Something went wrong:";
$lang['sites_siteAjax_error2_message'] = "Something went wrong when loading the site data. Please refresh your page and try again.";

// controllers/sites.php -> siteAjaxUpdate()
$lang['sites_siteAjaxUpdate_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_siteAjaxUpdate_error1_message'] = "Something went wrong when saving the site data, please see the errors below:<br><br>";

$lang['sites_siteAjaxUpdate_success_heading'] = "Yeah! All went well.";
$lang['sites_siteAjaxUpdate_success_message1'] = "The site's details were saved successfully!";
$lang['sites_siteAjaxUpdate_success_message2'] = "The site's details were saved successfully, <b>however the provided FTP details could not be used to successfully establish a connection; you won't be able to publish your site.</b>";

// controllers/sites.php -> publish()
$lang['sites_publish_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_publish_error1_message'] = "It appears the site ID is missing OR incorrect. Please refresh your page and try again.";

$lang['sites_publish_error2_heading'] = "Ouch! Something went wrong:";
$lang['sites_publish_error2_message'] = "It appears there are no assets selected for publication. Please select the assets you'd like to publish and try again.";

$lang['sites_publish_error3_heading'] = "Ouch! Something went wrong:";
$lang['sites_publish_error3_message'] = "We can not establish a connection to your FTP server, this caused by faulty connection data (server, user, password and/or port number). Please verify your connection details and update if needed before trying again. If you keep getting this error, your FTP server could be down as well.";

$lang['sites_publish_error4_heading'] = "Ouch! Something went wrong:";
$lang['sites_publish_error4_message'] = "It appears the /tmp folder is not writable. Please make sure the server can write to this folder.";

// controllers/sites.php -> trash()
$lang['sites_trash_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_trash_error1_message'] = "The site ID is missing or corrupt. Please try reloading the page and then try deleting the site once more.";

$lang['sites_trash_success_heading'] = "All set!";
$lang['sites_trash_success_message'] = "The site was successfully deleted from the system.";

// controllers/sites.php -> updatePageData()
$lang['sites_updatePageData_error1_heading'] = "Ouch! Something went wrong:";
$lang['sites_updatePageData_error1_message'] = "The site ID is missing or corrupt. Please try reloading the page and then try deleting the site once more.";

$lang['sites_updatePageData_success_heading'] = "All set!";
$lang['sites_updatePageData_success_message'] = "The page settings were successfully updated.";


// controllers/users.php -> create()
$lang['users_create_error1_heading'] = "Ouch! Something went wrong:";
$lang['users_create_error1_message'] = "Something went wrong when trying to cerate the new account, please see the errors below:<br><br>";

$lang['users_create_error2_heading'] = "Ouch! Something went wrong:";
$lang['users_create_error2_message'] = "The email address you're trying to use is already used by different account. Please choose a different email address";

$lang['users_create_success_heading'] = "Hooray!";
$lang['users_create_success_message'] = "The new account was created successfully!";


// controllers/users.php -> update()
$lang['users_update_error1_heading'] = "Ouch! Something went wrong:";
$lang['users_update_error1_message'] = "Something went wrong when trying to cerate the new account, please see the errors below:<br><br>";

$lang['users_update_error2_heading'] = "Ouch! Something went wrong:";
$lang['users_update_error2_message'] = "The email address you're trying to use is already used by different account. Please choose a different email address";

$lang['users_update_success_heading'] = "Hooray!";
$lang['users_update_success_message'] = "The account was updated successfully!";