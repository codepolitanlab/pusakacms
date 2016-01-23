<?php ('BASEPATH') OR exit('No direct script access allowed');

class Crud_anggota extends CPForm {

    function _set_config()
    {
        $this->title = "Anggota";
        $this->description = "Database Anggota";
        $this->table = "anggota";


        $this->fields['nama'] = array(
            'fieldType' => 'TextField',
            'label' => 'Nama Lengkap',
            'config' => array(
                'placeholder' => 'Your site name',
                'value'=>'Pusaka Site',
                'id' => 'site_name',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );

        $this->fields['email'] = array(
            'fieldType' => 'TextField',
            'label' => 'Email',
            'config' => array(
                'placeholder' => 'Just a Simple Homepage by PusakaCMS',
                'id' => 'site_slogan',
                'class' => 'form-control'
            ),
        );


    }

}
