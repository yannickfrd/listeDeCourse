<?php

namespace App\AppService;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailingService {
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function registerMailer(User $user) {
        $email = (new Email())
            ->from('contact.checklist@contactCheck.com')
            ->to($user->getEmail())
            ->subject('Inscription à la checklist')
            ->html($this->twig->render('mailing/registerMail.html.twig', ['user' => $user]));
        sleep(3);
        $this->mailer->send($email);
    }
}