<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
Use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct (private MailerInterface $mailer) {

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $subject, $content = '', $text = ''): void
    {

        $email = (new Email())
            ->from('noreply@antoninpamart.fr')
            ->to('contact@antoninpamart.fr')
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}