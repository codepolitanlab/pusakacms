<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['elements_dir'] = 'system/themes/jakarta/assets';
$config['images_dir'] = 'system/themes/jakarta/assets/images';
$config['images_uploadDir'] = 'system/themes/jakarta/assets/images/uploads';

$config['upload_allowed_types'] = "gif|jpg|png";
$config['upload_max_size'] = "1000";
$config['upload_max_width'] = "1024";
$config['upload_max_height'] = "768";

$config['images_allowedExtensions'] = 'jpg|png|gif|svg';//these are used when reading the image folder, not for uploading

$config['export_pathToAssets'] = "elements/bootstrap|elements/css|elements/fonts|elements/images|elements/js";
$config['export_fileName'] = "website.zip";
