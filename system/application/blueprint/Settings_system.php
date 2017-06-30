<?php ('BASEPATH') OR exit('No direct script access allowed');

class Settings_system extends CPForm {

    function _set_config()
    {
        $this->title = "System";

        // set form config
        $this->config = [
            'action' => site_url('panel/settings/index/'.get_class($this)),
            'method' => 'POST',
        ];
        $this->additional = [
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Submit Site Setting'
        ];

        
        $this->fields['theme'] = [
            'fieldType' => 'TextField',
            'label' => 'Theme',
            'config' => [
                'value'=>'jakarta',
                'id' => 'theme',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['theme_option'] = [
            'fieldType' => 'TextField',
            'label' => 'Theme Option',
            'config' => [
                'value' => 'orange',
                'id' => 'theme_option',
                'class' => 'form-control'
            ],
        ];

        $this->fields['admin_theme'] = [
            'fieldType' => 'TextField',
            'label' => 'Admin Theme',
            'config' => [
                'value' => 'pusakapanel',
                'id' => 'admin_theme',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['post_as_home'] = [
            'fieldType' => 'TextField',
            'label' => 'Post as home',
            'config' => [
                'value' => 'FALSE',
                'id' => 'post_as_home',
                'class' => 'form-control'
            ],
        ];

        $this->fields['post_term'] = [
            'fieldType' => 'TextField',
            'label' => 'Post term',
            'config' => [
                'value' => 'blog',
                'id' => 'post_term',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['post_per_page'] = [
            'fieldType' => 'TextField',
            'label' => 'Post per page',
            'config' => [
                'value' => '10',
                'id' => 'post_per_page',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['disqus_shortname'] = [
            'fieldType' => 'TextField',
            'label' => 'Disqus shortname',
            'config' => [
                'value' => 'pusakacms',
                'id' => 'disqus_shortname',
                'class' => 'form-control'
            ],
        ];

        $this->fields['export_location'] = [
            'fieldType' => 'TextField',
            'label' => 'Export location',
            'config' => [
                'placeholder' => 'Export location path, i.e. /var/www/html/site/ or C:/xampp/htdocs/site/',
                'id' => 'export_location',
                'class' => 'form-control'
            ],
        ];

    }

}
