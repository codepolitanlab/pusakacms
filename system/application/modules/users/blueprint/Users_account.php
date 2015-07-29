<?php
('BASEPATH') OR exit('No direct script access allowed');

class Users_account extends CPForm
{
    
    function _set_config() 
    {
        $this->cpform_title = "Users Account";
        
        // set form config
        $this->cpform_config = array(
            'action' => site_url('panel/users/create_user/'),
            'method' => 'POST',
        );
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-success',
            'submit_value' => 'Create Account'
        );
    }
    
    function _set_fields() 
    {
        $this->first_name = array(
            'fieldType' => 'TextField',
            'label' => 'First Name',
            'config' => array(
                'placeholder' => 'User first name',
                'value' => $this->cpform_CI->form_validation->set_value('first_name'),
                'id' => 'first_name',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );
        
        $this->last_name = array(
            'fieldType' => 'TextField',
            'label' => 'Last Name',
            'config' => array(
                'placeholder' => 'User last name',
                'value' => $this->cpform_CI->form_validation->set_value('last_name'),
                'id' => 'last_name',
                'class' => 'form-control'
            ),
        );
        
        $this->email = array(
            'fieldType' => 'TextField',
            'label' => 'Email',
            'config' => array(
                'placeholder' => 'i.e. user@domain.com',
                'value' => $this->cpform_CI->form_validation->set_value('email'),
                'id' => 'email',
                'class' => 'form-control'
            ),
            'rules' => array(
                'required',
                'valid_email',
                array('unique_email', array($this, 'unique_email'))
            ),
            'rule_messages' => array('unique_email' => 'Email already used. Choose another email.')
        );

        $this->password = array(
            'fieldType' => 'PasswordField',
            'label' => 'Password',
            'config' => array(
                'placeholder' => 'User password',
                'id' => 'password',
                'class' => 'form-control'
            ),
            'rules' => array(
                'required',
                'trim',
                'min_length[' . $this->cpform_CI->config->item('min_password_length', 'ion_auth') . ']',
                'max_length[' . $this->cpform_CI->config->item('max_password_length', 'ion_auth') . ']',
                'matches[password_confirm]'
            )
        );
        
        $this->password_confirm = array(
            'fieldType' => 'PasswordField',
            'label' => 'Confirm Password',
            'config' => array(
                'placeholder' => 'Type password again',
                'id' => 'password_confirm',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $options = array();
        // get groups
        $group_object = $this->cpform_CI->ion_auth->groups();
        // prepare data
        if ($this->cpform_CI->config->item('filebased', 'ion_auth')) 
            $groups = $group_object;
        else
            $groups = $group_object->result_array();
        // prepare checkbox options
        foreach ($groups as $group) $options[$group['id']] = $group['name'];

        $this->groups = array(
            'name' => 'groups[]',
            'fieldType' => 'CheckboxField',
            'label' => 'User Groups',
            'config' => array(
                'value' => '2',
                'data-toggle' => 'checkbox',
            ),
            'options' => $options
        );
    }

    function unique_email($email)
    {
        return ! (bool) $this->cpform_CI->ion_auth->email_check($email);
    }
    
}
