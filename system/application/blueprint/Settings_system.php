<?php ('BASEPATH') OR exit('No direct script access allowed');

class Settings_system extends CPForm {

    function set_fields()
    {
        $this->cpform_title = "System";

        $this->theme = array(
                'fieldType' => 'TextField',
                'label' => 'Theme',
                'config' => array(
                    'value'=>'jakarta',
                    'id' => 'theme',
                    'class' => 'form-control'
                ),
            );

        $this->theme_option = array(
                'fieldType' => 'TextField',
                'label' => 'Theme Option',
                'config' => array(
                    'value' => 'orange',
                    'id' => 'theme_option',
                    'class' => 'form-control'
                ),
            );

        $this->admin_theme = array(
                'fieldType' => 'TextField',
                'label' => 'Admin Theme',
                'config' => array(
                    'value' => 'pusakapanel',
                    'id' => 'admin_theme',
                    'class' => 'form-control'
                ),
            );

        $this->post_as_home = array(
                'fieldType' => 'TextField',
                'label' => 'Post as home',
                'config' => array(
                    'value' => 'FALSE',
                    'id' => 'post_as_home',
                    'class' => 'form-control'
                ),
            );

        $this->post_term = array(
                'fieldType' => 'TextField',
                'label' => 'Post term',
                'config' => array(
                    'value' => 'blog',
                    'id' => 'post_term',
                    'class' => 'form-control'
                ),
            );

        $this->post_per_page = array(
                'fieldType' => 'TextField',
                'label' => 'Post per page',
                'config' => array(
                    'value' => '10',
                    'id' => 'post_per_page',
                    'class' => 'form-control'
                ),
            );

        $this->disqus_shortname = array(
                'fieldType' => 'TextField',
                'label' => 'Disqus shortname',
                'config' => array(
                    'value' => 'pusakacms',
                    'id' => 'disqus_shortname',
                    'class' => 'form-control'
                ),
            );

        $this->export_location = array(
                'fieldType' => 'TextField',
                'label' => 'Export location',
                'config' => array(
                    'placeholder' => 'Export location path, i.e. /var/www/html/site/ or C:/xampp/htdocs/site/',
                    'id' => 'export_location',
                    'class' => 'form-control'
                ),
            );

    }

}
