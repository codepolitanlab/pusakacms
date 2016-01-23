<?php ('BASEPATH') OR exit('No direct script access allowed');

class Settings_system extends CPForm {

    function _set_config()
    {
        $this->title = "System";

        // set form config
        $this->config = array(
            'action' => site_url('panel/settings/index/'.get_class($this)),
            'method' => 'POST',
        );
        $this->additional = array(
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Submit Site Setting'
        );

        
        $this->fields['theme'] = array(
            'fieldType' => 'TextField',
            'label' => 'Theme',
            'config' => array(
                'value'=>'jakarta',
                'id' => 'theme',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['theme_option'] = array(
            'fieldType' => 'TextField',
            'label' => 'Theme Option',
            'config' => array(
                'value' => 'orange',
                'id' => 'theme_option',
                'class' => 'form-control'
            ),
        );

        $this->fields['admin_theme'] = array(
            'fieldType' => 'TextField',
            'label' => 'Admin Theme',
            'config' => array(
                'value' => 'pusakapanel',
                'id' => 'admin_theme',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['post_as_home'] = array(
            'fieldType' => 'TextField',
            'label' => 'Post as home',
            'config' => array(
                'value' => 'FALSE',
                'id' => 'post_as_home',
                'class' => 'form-control'
            ),
        );

        $this->fields['post_term'] = array(
            'fieldType' => 'TextField',
            'label' => 'Post term',
            'config' => array(
                'value' => 'blog',
                'id' => 'post_term',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['post_per_page'] = array(
            'fieldType' => 'TextField',
            'label' => 'Post per page',
            'config' => array(
                'value' => '10',
                'id' => 'post_per_page',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['disqus_shortname'] = array(
            'fieldType' => 'TextField',
            'label' => 'Disqus shortname',
            'config' => array(
                'value' => 'pusakacms',
                'id' => 'disqus_shortname',
                'class' => 'form-control'
            ),
        );

        $this->fields['export_location'] = array(
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
