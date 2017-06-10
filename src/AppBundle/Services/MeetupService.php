<?php
namespace AppBundle\Services;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Repository\MeetupGroupRepository;
use DMS\Service\Meetup\MeetupKeyAuthClient;

class MeetupService
{
    /** @var MeetupGroupRepository */
    private $meetupGroupRepo;

    /** @var MeetupKeyAuthClient  */
    private $meetupClient;

    /**
     * MeetupService constructor.
     */
    public function __construct(MeetupGroupRepository $groupRepository, MeetupKeyAuthClient $meetupClient)
    {
        $this->meetupClient = $meetupClient;
        $this->meetupGroupRepo = $groupRepository;
    }

    public function syncEvents() {

        $em = $this->meetupGroupRepo->createQueryBuilder('mg')->getEntityManager();
        $groups = $this->meetupGroupRepo->findAll();
        foreach($groups as $group) {
            /** @var MeetupGroup $group */
            $events = $this->meetupClient->getGroupEvents(['urlname' => $group->getUrlname(), 'status' => 'past,upcoming', 'page' => 25])->getData();
            foreach($events as $ev) {
                $meetupEvent = MeetupEvent::deserializeFromApi($ev);
                $em->persist($meetupEvent);
                $group->addEvent($meetupEvent);

            }
        }
        $em->flush();
        return $groups;
    }
}