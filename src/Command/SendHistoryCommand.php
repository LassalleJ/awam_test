<?php

namespace App\Command;

use App\Repository\CalculationsDoneRepository;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

#[AsCommand(
    name: 'app:send-history',
    description: 'Add a short description for your command',
)]
class SendHistoryCommand extends Command
{
    public function __construct(
        private CalculationsDoneRepository $calculationsDoneRepository,
        private MailerInterface $mailer
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $mailTo = $input->getArgument('email');

        if ($mailTo) {
            $io->note(sprintf('Vous avez demandé l\'envoi de l\'historique à l\'adresse suivante: %s', $mailTo));
        }
        $calculations = $this->calculationsDoneRepository->findAll();

        $email = (new TemplatedEmail())
            ->from('converter@test.com')
            ->to($mailTo)
            ->subject('Historique des calculs effectués')
            ->htmlTemplate('emails/email_history.html.twig')
            ->context([
                'calculationsDone' => $calculations,
                'date' => new DateTime('now')
            ])

            ;

        $this->calculationsDoneRepository->deleteHistory();
        $this->mailer->send($email);

        $io->success('Le mais a bien été envoyé, et l\'historique a été supprimé');

        return Command::SUCCESS;
    }
}
