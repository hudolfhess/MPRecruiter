<?php
namespace Application\InputFilter;

use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(
            array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 50
                        )
                    )
                )
            )
        );

        $this->add(
            array(
                'name' => 'email',
                'required' => true
            )
        );
    }

}