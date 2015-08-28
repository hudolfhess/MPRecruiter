<?php
namespace ApplicationTest\Form;

use Application\Form\RegisterForm;
use Application\InputFilter\RegisterFilter;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class RegisterFormTest extends AbstractControllerTestCase
{

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    /**
     * Dados tratados recebidos do formulário enviado pelo usuário.
     *
     * @return array
     */
    private function _getData() {
        return array(
            'name' => 'João da Silva',
            'email' => 'hudolf@gmail.com',
            'answer_1' => '5',
            'answer_2' => '5',
            'answer_3' => '5',
        );
    }

    private function _getFields()
    {
        return array(
            1 => 'HTML',
            2 => 'Javascript',
            3 => 'CSS'
        );
    }

    private function _getValidation($form, $data)
    {
        $form->setData($data);
        $inputFilter = new RegisterFilter();
        $form->setInputFilter($inputFilter);

        return $form->isValid();
    }

    public function testPass()
    {
        $form = new RegisterForm(
            $this->_getFields()
        );

        $result = $this->_getValidation(
            $form,
            $this->_getData()
        );

        $this->assertEquals(true, $result);
    }

    public function testNotPass()
    {
        $form = new RegisterForm(
            $this->_getFields()
        );

        $data = $this->_getData();
        $data['email'] = 'aaaa';

        $result = $this->_getValidation(
            $form,
            $data
        );

        $this->assertEquals(false, $result);
    }

    public function testNotPass2()
    {
        $form = new RegisterForm(
            $this->_getFields()
        );

        $result = $this->_getValidation(
            $form,
            array()
        );

        $this->assertEquals(false, $result);
    }

    public function testNotPass3()
    {
        $form = new RegisterForm(
            $this->_getFields()
        );

        $data = $this->_getData();
        $data['answer_2'] = '';
        $result = $this->_getValidation(
            $form,
            $data
        );

        $this->assertEquals(false, $result);
    }

}