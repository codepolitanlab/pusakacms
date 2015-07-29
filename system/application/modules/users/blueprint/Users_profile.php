<?php
('BASEPATH') OR exit('No direct script access allowed');

class Users_profile extends CPForm
{
    
    function _set_config() 
    {
        $this->cpform_title = "Users Profile";
        
        // set form config
        $this->cpform_config = array(
            'action' => site_url('panel/users/edit_profile/'),
            'method' => 'POST',
        );
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Create Account'
        );
    }
    
    function _set_fields() 
    {
        $this->company = array(
            'fieldType' => 'TextField',
            'label' => 'Company Name',
            'config' => array(
                'placeholder' => 'User company name',
                'value' => $this->cpform_CI->form_validation->set_value('company'),
                'id' => 'company',
                'class' => 'form-control'
            )
        );
        
        $this->phone = array(
            'fieldType' => 'TextField',
            'label' => 'Phone Number',
            'config' => array(
                'placeholder' => 'User phone number, separated by comma',
                'value' => $this->cpform_CI->form_validation->set_value('phone'),
                'id' => 'phone',
                'class' => 'form-control'
            ),
        );        

    }
    
}
