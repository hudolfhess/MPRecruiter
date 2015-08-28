<?php
namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{

    /**
     * @param array $addFields Campos respostas a serem adicionados ao formulário
     */
    public function __construct(array $addFields)
    {
        parent::__construct('register');

        $this->add(
            array(
                'name' => 'name',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Nome',
                ),
            )
        );
        $this->add(
            array(
                'name' => 'email',
                'type' => 'Email',
                'options' => array(
                    'label' => 'E-mail',
                ),
            )
        );

        foreach ($addFields as $name=>$label) {
            $f = array(
                'type' => 'Radio',
                'name' => 'answer_' . $name,
                'options' => array(
                    'label' => $label,
                    'value_options' => array(
                        0 => '0',
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                        7 => '7',
                        8 => '8',
                        9 => '9',
                        10 => '10',
                    )
                )
            );
            $this->add($f);
            $this->elements['answer_' . $name]->setValue('0');
        };

        $this->add(
            array(
                'name' => 'submit',
                'type' => 'Submit',
                'attributes' => array(
                    'value' => 'Enviar',
                    'id' => 'submitbutton',
                ),
            )
        );
    }

}