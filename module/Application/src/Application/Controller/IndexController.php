<?php
namespace Application\Controller;

use Application\Form\RegisterForm;
use Application\Service\RegisterService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $jobId = 1;

        $objectManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $jobRespository = $objectManager->getRepository('\Application\Entity\Job');
        $job = $jobRespository->find($jobId);

        if ($job) {
            $addFields = $job->getFieldQuestions();

            $form = new RegisterForm($addFields);
            $form->setData(
                $this->params()->fromPost()
            );

            if ($this->getRequest()->getMethod() == 'POST') {
                /**
                 * @var $registerService RegisterService
                 */
                $registerService = $this->getServiceLocator()->get('RegisterService');
                $registerService->setJob($job);
                $registerService->setForm($form);

                if ($registerService->isValid()) {
                    $register = $registerService->save();

                    if ($register) {
                        return $this->redirect()->toUrl('application/index/success');
                    }
                }
            }

            return new ViewModel(
                array(
                    'form' => $form,
                    'job' => $job,
                    'addFields' => array_keys($addFields)
                )
            );
        } else {
            return $this->redirect()->toUrl('application/index/error');
        }
    }

    public function erroAction()
    {
        return new ViewModel();
    }

    public function successAction()
    {
        return new ViewModel();
    }
}
