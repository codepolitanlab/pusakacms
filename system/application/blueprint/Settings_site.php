<?php ('BASEPATH') OR exit('No direct script access allowed');

class Settings_site extends CPForm {

    function _set_config()
    {
        $this->title = "Site";

        // set form config
        $this->config = array(
            'action' => site_url('panel/settings/index/'.get_class($this)),
            'method' => 'POST',
        );
        $this->additional = array(
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Submit Site Setting'
        );

        
        $this->fields['site_name'] = array(
            'fieldType' => 'TextField',
            'label' => 'Site Name',
            'config' => array(
                'placeholder' => 'Your site name',
                'value'=>'Pusaka Site',
                'id' => 'site_name',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['site_slogan'] = array(
            'fieldType' => 'TextField',
            'label' => 'Site Slogan',
            'config' => array(
                'placeholder' => 'Just a Simple Homepage by PusakaCMS',
                'id' => 'site_slogan',
                'class' => 'form-control'
            ),
        );

        $this->fields['site_owner'] = array(
            'fieldType' => 'TextField',
            'label' => 'Site Owner Name',
            'config' => array(
                'placeholder' => 'John Doe',
                'id' => 'site_owner',
                'class' => 'form-control'
            ),
        );

        $this->fields['site_domain'] = array(
            'fieldType' => 'TextField',
            'label' => 'Site Domain',
            'config' => array(
                'placeholder' => 'i.e. mydomain.com',
                'id' => 'site_domain',
                'class' => 'form-control'
            ),
        );

        $this->fields['protocol'] = array(
            'fieldType' => 'TextField',
            'label' => 'Protocol',
            'config' => array(
                'value' => 'http',
                'id' => 'protocol',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['meta_description'] = array(
            'fieldType' => 'TextField',
            'label' => 'Meta description',
            'config' => array(
                'placeholder' => 'Your site description',
                'id' => 'meta_description',
                'class' => 'form-control'
            ),
        );

        $this->fields['meta_keywords'] = array(
            'fieldType' => 'TextField',
            'label' => 'Meta keywords',
            'config' => array(
                'placeholder' => 'Your site keywords',
                'id' => 'meta_keywords',
                'class' => 'form-control'
            ),
        );

    }

}
