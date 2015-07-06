<?php ('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CPForm {

    function set_fields()
    {
        $this->username = array(
                'fieldType' => 'TextField',
                'label' => 'Username',
                'config' => array(
                    'placeholder' => 'isi dengan name anda...',
                    'value'=>'ridwanbejo',
                    'id' => 'name',
                    'class' => 'form-control'
                ),
            );

        $this->first_name = array(
                'fieldType' => 'TextField',
                'label' => 'Nama Depan',
                'config' => array(
                    'placeholder' => 'isi dengan first name anda...',
                    'id' => 'first_name',
                    'class' => 'form-control'
                ),
            );

        $this->last_name = array(
                'fieldType' => 'TextField',
                'label' => 'Nama Belakang',
                'config' => array(
                    'placeholder' => 'isi dengan last name anda...',
                    'id' => 'last_name',
                    'class' => 'form-control'
                ),
            );

        $this->email = array(
                'fieldType' => 'TextField',
                'label' => 'Email',
                'config' => array(
                    'placeholder' => 'isi dengan e-mail anda...',
                    'id' => 'email',
                    'class' => 'form-control'
                ),
            );

        $this->website = array(
                'fieldType' => 'TextField',
                'label' => 'Website',
                'config' => array(
                    'placeholder' => 'isi dengan website anda...',
                    'id' => 'website',
                    'class' => 'form-control'
                ),
            );

    }

}
