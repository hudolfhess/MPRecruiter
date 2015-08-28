<?php
namespace Application\Service;

use Application\Core\Service;
use Application\Entity\Job;
use Application\Entity\Register;
use Application\Entity\RegisterJobRule;
use Application\Entity\RegisterQuestion;
use Application\Form\RegisterForm;
use Application\InputFilter\RegisterFilter;
use Application\Validator\RecruiterValidator;

class RegisterService extends Service
{

    /**
     * @var RegisterForm
     */
    private $_form;

    /**
     * @var Job
     */
    private $_job;

    /**
     * @var bool
     */
    private $_isValid = false;

    /**
     * Informa a vaga a ser vinculada ao registro atual
     *
     * @param Job $job Registro da vaga
     */
    public function setJob(Job $job)
    {
        $this->_job = $job;
    }

    /**
     * Informa o formulário com os dados recebidos pela requisição
     *
     * @param RegisterForm $form Formulário de registro
     */
    public function setForm(RegisterForm $form)
    {
        $this->_form = $form;
    }

    /**
     * Gera o InputFilter para validação do formulário e
     * valida os dados recebidos pelo cliente.
     *
     * @param array $data Dados a serem validados
     *
     * @return bool
     */
    public function isValid(array $data = array())
    {
        if ($this->_form) {
            if (count($data) > 0) {
                $this->_form->setData($data);
            }
            $registerFilter = new RegisterFilter();
            $this->_form->setInputFilter($registerFilter);
            $this->_isValid = $this->_form->isValid();
        }
        return $this->_isValid;
    }

    /**
     * Cria o registro e gera todas as dependências do mesmo.
     *
     * @return Register|bool
     */
    public function save()
    {
        if ($this->_form && $this->_job && $this->_isValid === true) {
            $recruiterValidator = new RecruiterValidator();
            $recruiterValidator->setData(
                $this->_form->getData(),
                true
            );
            $recruiterValidator->setRules(
                $this->_job->getRules()
            );
            $recruiterValidator->setDefaultRule(
                $this->_job->getDefaultRule()
            );

            $result = $recruiterValidator->run();

            if ($result !== false) {
                $objectManager = $this
                    ->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');

                $jobQuestionRepository = $objectManager->getRepository('\Application\Entity\JobQuestion');
                $jobRuleRepository = $objectManager->getRepository('\Application\Entity\JobRule');
                $registerRepository = $objectManager->getRepository('\Application\Entity\Register');

                $data = (array) $this->_form->getData();

                $register = new Register();
                $register->job = $this->_job;
                $register->name = $data['name'];
                $register->email = $data['email'];

                $answersData = $recruiterValidator->prepareData();
                $rulesData = $recruiterValidator->prepareRules($result->rules);

                $objectManager->persist($register);

                foreach ($answersData as $aData) {
                    $registerQuestion = new RegisterQuestion();
                    $registerQuestion->register = $register;
                    $registerQuestion->questions = $jobQuestionRepository->find($aData['job_question_id']);
                    $registerQuestion->value = $aData['value'];

                    $objectManager->persist($registerQuestion);
                }

                foreach ($rulesData as $rData) {
                    $registerRule = new RegisterJobRule();
                    $registerRule->register = $register;
                    $registerRule->rules = $jobRuleRepository->find($rData['job_rule_id']);

                    $objectManager->persist($registerRule);
                }
                $objectManager->flush();
                $registerRepository->clear();
                $register = $registerRepository->find($register->id);
                $this->prepareEmails($register);
                return $register;
            }
        }
        return false;
    }

    /**
     * Prepara os e-mails a serem disparados conforme as regras
     * definidas pela vaga vinculada ao registro.
     *
     * @param Register $register Registro salvo no banco
     */
    public function prepareEmails(Register $register)
    {
        $emailService = $this->getServiceLocator()->get('EmailService');

        foreach ($register->rules as $rule) {
            $emailService->sendEmail(
                $register->name,
                $register->email,
                $rule->rules->email_subject,
                $rule->rules->email_content
            );
        }
    }

}