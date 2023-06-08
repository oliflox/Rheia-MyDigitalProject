<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService{
    public function __construct(private readonly MailerInterface $mailerInterface){}

    public function send(
        string $to,
        string $subject,
        string $templatetwig,
        array $context) : void{
            $email = (new TemplatedEmail())
            ->from(new Address('noreply@BoutiqueAled.fr', 'BoutiqueAled'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("mails/$templatetwig")
            ->context($context);

            try{
                $this->mailer->send($email);
            }catch(TransportExceptionInterface $transportException){
                throw $transportException;
            }
        }
}