<?php

namespace App\Command;

use App\Entity\FruitFamily;
use App\Entity\FruitGenus;
use App\Entity\FruitOrder;
use App\Service\FruitService;
use Symfony\Component\Mailer\MailerInterface;
use App\EventSubscriber\SendSuccessEmailEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'app:fruits-fetch',
    description: 'Responsible for getting all the fruits from third party.',
)]
class FruitsFetchCommand extends Command
{
    private FruitService $service;
    private MailerInterface $mailer;
    private ContainerInterface $container;
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param MailerInterface $mailer
     * @param ContainerInterface $container
     * @param EventDispatcherInterface $eventDispatcher
     * @param string|null $name
     */
    public function __construct(
        MailerInterface $mailer,
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher,
        FruitService $service,
        string $name = null
    ) {
        parent::__construct($name);
        $this->service = $service;
        $this->mailer = $mailer;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input,OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            list($status, $data) = $this->service->fetchFruits();
            if ($status == false) {
                $io->error($data);
                return Command::FAILURE;
            }

            $io->info("Processing ".count($data)." records...");
            $this->processImport($data, $io);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('Fruits Imported Successfully!');
        return Command::SUCCESS;
    }

    /**
     * @param array $data
     * @param SymfonyStyle $io
     */
    private function processImport(array $data, SymfonyStyle $io): void
    {
        $response = ['Total Records' => count($data), 'Updated' => 0, 'Created' => 0];
        foreach ($data as $fruit) {
            $fruit['family'] = $this->service->handleFruitDepends('family', $fruit['family']);
            $fruit['genus'] = $this->service->handleFruitDepends('genus', $fruit['genus']);
            $fruit['order'] = $this->service->handleFruitDepends('order', $fruit['order']);
            $fruit['nutrition'] = $this->service->handleFruitNutrition($fruit['nutritions']);

            $isCreated = $this->service->handleFruitEntity($fruit);
            if ($isCreated) {
                $response['Created'] += 1;
            } else {
                $response['Updated'] += 1;
            }
        }

        $io->table(["Total Records", "Updated", "Created"], [$response]);

        // Sending the email to admin
        $event = new SendSuccessEmailEvent($this->mailer, $this->container, ['extraData' => $response]);
        $this->eventDispatcher->dispatch($event, SendSuccessEmailEvent::NAME);
    }
}
