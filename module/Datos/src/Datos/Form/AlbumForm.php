<?php
namespace Datos\Form;

use Zend\Form\Form;

class DatosForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('datos');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nombre',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'nombre',
            ),
        ));

        $this->add(array(
            'name' => 'foto',
            'attributes' => array(
                'type'  => 'foto',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Agregar',
                'id' => 'submitbutton',
            ),
        ));

    }
}
