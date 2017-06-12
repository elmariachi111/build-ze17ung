<?php

namespace AppBundle\Command;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Services\MeetupService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncMeetupCommand extends ContainerAwareCommand
{
    const COMMAND_ADD_GROUP = 'add';
    const COMMAND_SYNC_EVENTS = 'sync';

    protected function configure()
    {
        $this
            ->setName('app:meetup')
            ->addArgument('cmd', InputArgument::OPTIONAL, 'command', self::COMMAND_SYNC_EVENTS)
            ->addArgument('group', InputArgument::OPTIONAL, 'group urlalias')
            ->setDescription('');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $groupUrlAlias = $input->getArgument('group');

        switch ($input->getArgument('cmd')) {
            case self::COMMAND_ADD_GROUP: return $this->addGroup($groupUrlAlias); break;
            case self::COMMAND_SYNC_EVENTS: return $this->syncEvents($groupUrlAlias); break;
        }
    }

    protected function addGroup($groupUrlAlias) {

        $exists = null !=$this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(MeetupGroup::class)->find($groupUrlAlias);

        $group = $this->getContainer()->get(MeetupService::class)->getMeetupGroup($groupUrlAlias);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->merge($group);
        $em->flush();

        if (!$exists) {
            $this->syncEvents($groupUrlAlias);
        }
    }

    protected function syncEvents($groupUrlAlias = null)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $meetupGroup = $em->getRepository(MeetupGroup::class)->find($groupUrlAlias);

        $events = $this->getContainer()->get(MeetupService::class)->syncEvents($meetupGroup);
        foreach($events as $event) {
            $em->merge($event);
        }
        $em->flush();
    }
}
