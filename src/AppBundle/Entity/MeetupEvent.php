<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeetupEvent
 *
 * @ORM\Table(name="meetup_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetupEventRepository")
 */
class MeetupEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", length=50)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="how_to_find_us", type="string", length=255, nullable=true)
     */
    private $howToFindUs;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=30)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="yes_rsvp_count", type="integer", nullable=true)
     */
    private $yesRsvpCount;

    /**
     * @var int
     *
     * @ORM\Column(name="waitlist_count", type="integer", nullable=true)
     */
    private $waitlistCount;

    /**
     * @var string
     * @ORM\Column(name="venue_name", type="string", length=255, nullable=true)
     */
    private $venueName;

    /**
     * @var string
     * @ORM\Column(name="venue_address", type="string", length=255, nullable=true)
     */
    private $venueAddress;

    /**
     * @var array
     * @ORM\Column(name="venue_location", type="json_array", nullable=true)
     */
    private $venueLocation;

    /**
     * @var MeetupGroup
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MeetupGroup", inversedBy="events")
     * @ORM\JoinColumn(name="meetupgroup_urlname", referencedColumnName="urlname")
     */
    private $meetupGroup;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MeetupEvent
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set howToFindUs
     *
     * @param string $howToFindUs
     *
     * @return MeetupEvent
     */
    public function setHowToFindUs($howToFindUs)
    {
        $this->howToFindUs = $howToFindUs;

        return $this;
    }

    /**
     * Get howToFindUs
     *
     * @return string
     */
    public function getHowToFindUs()
    {
        return $this->howToFindUs;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return MeetupEvent
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MeetupEvent
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return MeetupEvent
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return MeetupEvent
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set yesRsvpCount
     *
     * @param integer $yesRsvpCount
     *
     * @return MeetupEvent
     */
    public function setYesRsvpCount($yesRsvpCount)
    {
        $this->yesRsvpCount = $yesRsvpCount;

        return $this;
    }

    /**
     * Get yesRsvpCount
     *
     * @return int
     */
    public function getYesRsvpCount()
    {
        return $this->yesRsvpCount;
    }

    /**
     * Set waitlistCount
     *
     * @param integer $waitlistCount
     *
     * @return MeetupEvent
     */
    public function setWaitlistCount($waitlistCount)
    {
        $this->waitlistCount = $waitlistCount;

        return $this;
    }

    /**
     * Get waitlistCount
     *
     * @return int
     */
    public function getWaitlistCount()
    {
        return $this->waitlistCount;
    }

    /**
     * @return string
     */
    public function getVenueName()
    {
        return $this->venueName;
    }

    /**
     * @param string $venueName
     */
    public function setVenueName(string $venueName)
    {
        $this->venueName = $venueName;
    }

    /**
     * @return string
     */
    public function getVenueAddress()
    {
        return $this->venueAddress;
    }

    /**
     * @param string $venueAddress
     */
    public function setVenueAddress(string $venueAddress)
    {
        $this->venueAddress = $venueAddress;
    }

    /**
     * @return array
     */
    public function getVenueLocation()
    {
        return $this->venueLocation;
    }

    /**
     * @param array $venueLocation
     */
    public function setVenueLocation(array $venueLocation)
    {
        $this->venueLocation = $venueLocation;
    }

    /**
     * @return mixed
     */
    public function getMeetupGroup()
    {
        return $this->meetupGroup;
    }

    /**
     * @param mixed $meetupGroup
     */
    public function setMeetupGroup($meetupGroup)
    {
        $this->meetupGroup = $meetupGroup;
    }

    public function isPast() {
        return ($this->getTime() < new \DateTime());
    }

    public static function deserializeFromApi(array $apiEvent) {
        $event = new self;
        $event->id = $apiEvent['id'];
        $event->setName($apiEvent['name']);
        $event->setDescription($apiEvent['description']);
        //$event->setHowToFindUs($apiEvent['how_to_find_us']);
        $event->setLink($apiEvent['link']);
        $event->setStatus($apiEvent['status']);
        $event->setWaitlistCount($apiEvent['waitlist_count']);
        $event->setYesRsvpCount($apiEvent['yes_rsvp_count']);

        if (isset($apiEvent['venue'])) {
            $event->setVenueAddress($apiEvent['venue']['address_1'] . ' ' . $apiEvent['venue']['city']);
            $event->setVenueName($apiEvent['venue']['name']);
            $event->setVenueLocation([
                'lat' => $apiEvent['venue']['lat'],
                'lon' => $apiEvent['venue']['lon'],
            ]);
        }

        $timeStamp = '@' . $apiEvent['time']/1000;
        $time = new \DateTime($timeStamp);
        $time->setTimezone(new \DateTimeZone('Europe/Berlin') );
        $event->setTime($time);
        return $event;
    }
}

