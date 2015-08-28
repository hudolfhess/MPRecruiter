<?php
namespace Application\Service;

use Application\Core\Service;
use Zend\Mail;

class EmailService extends Service
{

    /**
     * Dispara um e-mail conforme as configurações fornecidas.
     *
     * @param string $name    Nome do remetente
     * @param string $email   E-mail do remetente
     * @param string $subject Assunto do e-mail
     * @param string $message Conteúdo a ser enviado
     */
    public function sendEmail
    (
        $name,
        $email,
        $subject,
        $message
    ) {
        $mail = new Mail\Message();
        $mail->addTo($email, $name);
        $mail->setFrom('recruiter@recuiter.org', 'MPRecruiter');
        $mail->setSubject($subject);
        $mail->setBody($message);

        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
    }

}