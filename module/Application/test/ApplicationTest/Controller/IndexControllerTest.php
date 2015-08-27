<?php
namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class IndexControllerTest extends AbstractControllerTestCase
{

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    /**
     * Padrão de regras a serem enviadas ao RecruiterValidator.
     *
     * @return array
     */
    private function _getRules()
    {
        return array(
            'backend' => array(
                'rules' => array(
                    'python' => 7,
                    'django' => 7
                ),
                'email' => 'backend'
            ),
            'frontend' => array(
                'rules' => array(
                    'html' => 7,
                    'css' => 7,
                    'javascript' => 7
                ),
                'email' => 'frontend'
            ),
            'mobile' => array(
                'rules' => array(
                    'ios' => 7,
                    'android' => 7
                ),
                'email' => 'mobile'
            ),
            '__default' => array(
                'email' => 'generic'
            )
        );
    }

    /**
     * Dados tratados recebidos do formulário enviado pelo usuário.
     *
     * @param array $answers Dados a serem mesclados com dados padrões
     *
     * @return array
     */
    private function _getData($answers = array()) {
        $data = array(
            'name' => 'João da Silva',
            'email' => 'hudolf@gmail.com',
            'answers' => array(
                'html' => 5,
                'css' => 5,
                'javascript' => 5,
                'python' => 5,
                'django' => 5,
                'ios' => 5,
                'android' => 5
            )
        );

        if (count($answers) > 0) {
            $data['answers'] = array_merge($data['answers'], $answers);
        }

        return $data;
    }

    private function _getResult($data)
    {
        $recruiterService = new \Application\Validator\RecruiterValidator();
        $recruiterService->setData($data['answers']);
        $recruiterService->setRules(
            $this->_getRules()
        );
        return $recruiterService->run();
    }

    public function testGeneric()
    {
        $data = $this->_getData();
        $result = $this->_getResult($data);

        $this->assertEquals('1', count($result->emails));
        $this->assertEquals('generic', $result->emails[0]);
    }

    public function testBackend()
    {
        $data = $this->_getData(
            array(
                'django' => 8,
                'python' => 9
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('1', count($result->emails));
        $this->assertEquals('backend', $result->emails[0]);
    }

    public function testFrondend()
    {
        $data = $this->_getData(
            array(
                'html' => 8,
                'css' => 9,
                'javascript' => 9
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('1', count($result->emails));
        $this->assertEquals('frontend', $result->emails[0]);
    }

    public function testMobile()
    {
        $data = $this->_getData(
            array(
                'ios' => 8,
                'android' => 9
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('1', count($result->emails));
        $this->assertEquals('mobile', $result->emails[0]);
    }

    public function testMobileAndFrontend()
    {
        $data = $this->_getData(
            array(
                'ios' => 8,
                'android' => 9,
                'html' => 10,
                'css' => 9,
                'javascript' => 8
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('2', count($result->emails));
        $this->assertEquals(true, in_array('mobile', $result->emails));
        $this->assertEquals(true, in_array('frontend', $result->emails));

    }

    public function testMobileAndBackend()
    {
        $data = $this->_getData(
            array(
                'ios' => 8,
                'android' => 9,
                'django' => 7,
                'python' => 10
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('2', count($result->emails));
        $this->assertEquals(true, in_array('mobile', $result->emails));
        $this->assertEquals(true, in_array('backend', $result->emails));
    }

    public function testFrontendAndBackend()
    {
        $data = $this->_getData(
            array(
                'html' => 8,
                'css' => 9,
                'javascript' => 7,
                'django' => 7,
                'python' => 10,
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('2', count($result->emails));
        $this->assertEquals(true, in_array('frontend', $result->emails));
        $this->assertEquals(true, in_array('backend', $result->emails));
    }

    public function testAll()
    {
        $data = $this->_getData(
            array(
                'ios' => 8,
                'android' => 9,
                'django' => 7,
                'python' => 10,
                'html' => 10,
                'css' => 9,
                'javascript' => 8
            )
        );
        $result = $this->_getResult($data);

        $this->assertEquals('3', count($result->emails));
        $this->assertEquals(true, in_array('mobile', $result->emails));
        $this->assertEquals(true, in_array('frontend', $result->emails));
        $this->assertEquals(true, in_array('backend', $result->emails));
    }

}