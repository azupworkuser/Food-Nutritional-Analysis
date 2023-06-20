<?php
namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\EventDispatcher\Event;

class SendSuccessEmailEvent extends Event
{
    public const NAME = 'import.success';

    private MailerInterface $mailer;
    private ContainerInterface $container;
    private array $extraData;

    /**
     * @param MailerInterface $mailer
     * @param ContainerInterface $container
     * @param array $extraData
     */
    public function __construct(MailerInterface $mailer, ContainerInterface $container, array $extraData = [])
    {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->extraData = $extraData;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return 'Data imported successfully!';
    }

    /**
     * @return ContainerInterface
     */
    private function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getParameter(string $name): string
    {
        return $this->getContainer()->getParameter($name);
    }

    /**
     * @return array
     */
    public function getExtraData(): array
    {
        return $this->extraData;
    }

    /**
     * @param Email $email
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendEmail(Email $email): void
    {
        $this->mailer->send($email);
    }
}