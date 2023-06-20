<?php

namespace App\EventSubscriber;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendSuccessEmailSubscriber implements EventSubscriberInterface
{
    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SendSuccessEmailEvent::NAME => 'onImportSuccess'
        ];
    }

    public function onImportSuccess(SendSuccessEmailEvent $event): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($event->getParameter('app.mail_from_address'), $event->getParameter('app.mail_from_name')))
            ->to(new Address($event->getParameter('app.mail_admin_address'), $event->getParameter('app.mail_admin_name')))
            ->subject($event->getSubject())
            ->htmlTemplate('emails/import-success.html.twig')
            ->context(array_merge($event->getExtraData(), [
                'link' => $event->getParameter('app.frontend_url'),
                'username' => $event->getParameter('app.mail_admin_name')
            ]));

        $event->sendEmail($email);
    }
}
