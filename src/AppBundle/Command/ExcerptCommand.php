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

class ExcerptCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:excerpt')
            ->addArgument('url', InputArgument::REQUIRED,'url')
            ->setDescription('add an article');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $excerpt = $this->getContainer()->get(MercuryExcerptService::class)->getExcerpt($url);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($excerpt);
        $em->flush();
    }

}
