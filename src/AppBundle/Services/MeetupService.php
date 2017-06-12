<?php
namespace AppBundle\Services;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Repository\MeetupGroupRepository;
use DMS\Service\Meetup\MeetupKeyAuthClient;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class MeetupService
{
    /** @var MeetupKeyAuthClient  */
    private $meetupClient;

    /** @var Serializer */
    private $serializer;

    /**
     * MeetupService constructor.
     */
    public function __construct(MeetupKeyAuthClient $meetupClient)
    {
        $this->meetupClient = $meetupClient;
    }

    /**
     * @param MeetupGroup $meetupGroup
     * @return MeetupEvent[]
     */
    public function syncEvents(MeetupGroup $meetupGroup) : array {
        /** @var MeetupGroup $group */
        $events = $this->meetupClient->getGroupEvents(['urlname' => $meetupGroup->getUrlname(), 'status' => 'past,upcoming', 'page' => 25])->getData();
        $ret = [];
        foreach($events as $ev) {
            $meetupEvent = MeetupEvent::deserializeFromApi($ev);
            $meetupEvent->setMeetupGroup($meetupGroup);
            $ret[] = $meetupEvent;
        }
        return $ret;
    }

    public function getMeetupGroup(string $urlAlias) : MeetupGroup {
        $response = $this->meetupClient->getGroup(['urlname' => $urlAlias])->getData();

        $meetupGroup = new MeetupGroup();
        $meetupGroup->setUrlname($response['urlname']);
        $meetupGroup->setId($response['id']);
        $meetupGroup->setName($response['name']);
        $meetupGroup->setCreated((new \DateTime)->setTimestamp($response['created']/1000));
        $meetupGroup->setDescription($response['description']);

        return $meetupGroup;
    }
}