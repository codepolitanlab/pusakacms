<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/CPForm.php';

class Contact extends CPForm {

    public function __construct()
    {

        $this->username = [
                'fieldType' => 'TextField',
                'initial'=>'ridwanbejo',
                'config' => [
                    'placeholder' => 'isi dengan name anda...',
                    'id' => 'name'
                ],
            ];

        $this->first_name = [
                'fieldType' => 'TextField',
                'initial'=>'',
                'config' => [
                    'placeholder' => 'isi dengan first name anda...',
                    'id' => 'first_name'
                ],
            ];

        $this->last_name = [
                'fieldType' => 'TextField',
                'initial'=>'',
                'config' => [
                    'placeholder' => 'isi dengan last name anda...',
                    'id' => 'last_name'
                ],
            ];

        $this->email = [
                'fieldType' => 'TextField',
                'initial'=>'',
                'config' => [
                    'placeholder' => 'isi dengan e-mail anda...',
                    'id' => 'email'
                ],
            ];

        $this->website = [
                'fieldType' => 'TextField',
                'initial'=>'',
                'config' => [
                    'placeholder' => 'isi dengan website anda...',
                    'id' => 'website'
                ],
            ];
    }

}
