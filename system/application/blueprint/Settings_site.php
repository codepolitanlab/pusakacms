<?php ('BASEPATH') OR exit('No direct script access allowed');

class Settings_site extends CPForm {

    function _set_config()
    {
        $this->title = "Site";

        // set form config
        $this->config = [
            'action' => site_url('panel/settings/index/'.get_class($this)),
            'method' => 'POST',
        ];
        $this->additional = [
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Submit Site Setting'
        ];

        
        $this->fields['site_name'] = [
            'fieldType' => 'TextField',
            'label' => 'Site Name',
            'config' => [
                'placeholder' => 'Your site name',
                'value'=>'Pusaka Site',
                'id' => 'site_name',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['site_slogan'] = [
            'fieldType' => 'TextField',
            'label' => 'Site Slogan',
            'config' => [
                'placeholder' => 'Just a Simple Homepage by PusakaCMS',
                'id' => 'site_slogan',
                'class' => 'form-control'
            ],
        ];

        $this->fields['site_owner'] = [
            'fieldType' => 'TextField',
            'label' => 'Site Owner Name',
            'config' => [
                'placeholder' => 'John Doe',
                'id' => 'site_owner',
                'class' => 'form-control'
            ],
        ];

        $this->fields['site_domain'] = [
            'fieldType' => 'TextField',
            'label' => 'Site Domain',
            'config' => [
                'placeholder' => 'i.e. mydomain.com',
                'id' => 'site_domain',
                'class' => 'form-control'
            ],
        ];

        $this->fields['protocol'] = [
            'fieldType' => 'TextField',
            'label' => 'Protocol',
            'config' => [
                'value' => 'http',
                'id' => 'protocol',
                'class' => 'form-control'
            ],
            'rules' => 'required'
        ];

        $this->fields['meta_description'] = [
            'fieldType' => 'TextField',
            'label' => 'Meta description',
            'config' => [
                'placeholder' => 'Your site description',
                'id' => 'meta_description',
                'class' => 'form-control'
            ],
        ];

        $this->fields['meta_keywords'] = [
            'fieldType' => 'TextField',
            'label' => 'Meta keywords',
            'config' => [
                'placeholder' => 'Your site keywords',
                'id' => 'meta_keywords',
                'class' => 'form-control'
            ],
        ];

    }

}
