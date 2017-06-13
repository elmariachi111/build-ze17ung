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
            case self::COMMAND_ADD_GROUP: return $this->addGroup($groupUrlAlias, $output); break;
            case self::COMMAND_SYNC_EVENTS: return $this->syncEvents($groupUrlAlias, $output); break;
        }
    }

    protected function addGroup($groupUrlAlias, OutputInterface $output) {

        $exists = null !=$this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(MeetupGroup::class)->find($groupUrlAlias);

        $group = $this->getContainer()->get(MeetupService::class)->getMeetupGroup($groupUrlAlias);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->merge($group);
        $em->flush();

        if (!$exists) {
            $this->syncEvents($groupUrlAlias, $output);
        }
    }

    protected function syncEvents($groupUrlAlias = null, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        if (null !== $groupUrlAlias) {
            $meetupGroup = $em->getRepository(MeetupGroup::class)->find($groupUrlAlias);
            $this->syncGroup($meetupGroup, $output);
        } else {
            $groups = $em->getRepository(MeetupGroup::class)->findAll();
            foreach($groups as $meetupGroup) {
                $this->syncGroup($meetupGroup, $output);
            }
        }

        $em->flush();
    }

    private function syncGroup(MeetupGroup $meetupGroup, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $output->write("Syncing {$meetupGroup->getName()}... ");
        $events = $this->getContainer()->get(MeetupService::class)->syncEvents($meetupGroup);
        foreach($events as $event) {
            $em->merge($event);
        }
        $output->writeln(count($events) . " Done.");
    }
}
