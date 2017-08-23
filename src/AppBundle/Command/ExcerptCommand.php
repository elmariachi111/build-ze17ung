<?php

namespace AppBundle\Command;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Services\GooseExcerptService;
use AppBundle\Services\MeetupService;
use AppBundle\Services\MercuryExcerptService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
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
        $excerpt = $this->getContainer()->get(GooseExcerptService::class)->getExcerpt($url);

        $table = new Table($output);
        $table->setHeaders([
            'title',
            'author',
            'datePublished',
            'leadImageUrl',
            'excerpt',
            'url',
            'domain'
        ]);
        $table->addRow([
            $excerpt->getTitle(),
            $excerpt->getAuthor(),
            $excerpt->getDatePublished() ? $excerpt->getDatePublished()->format(\DateTime::ISO8601): '',
            $excerpt->getLeadImageUrl() ?: '',
            $excerpt->getExcerpt(),
            $excerpt->getUrl(),
            $excerpt->getDomain()
        ]);
        $table->render();

        /*$em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($excerpt);
        $em->flush();
        */
    }

}
