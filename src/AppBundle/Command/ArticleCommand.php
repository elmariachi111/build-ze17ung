<?php

namespace AppBundle\Command;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Services\MeetupService;
use AppBundle\Services\MercuryExcerptService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ArticleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:article')
            ->addArgument('url', InputArgument::REQUIRED,'url')
            ->setDescription('add an article');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $resp = $this->getContainer()->get(MercuryExcerptService::class)->getExcerpt($url);

    }

}
