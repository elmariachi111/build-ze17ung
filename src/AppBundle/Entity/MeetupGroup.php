<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * MeetupGroup
 *
 * @ORM\Table(name="meetup_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetupGroupRepository")
 */
class MeetupGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="urlname", type="string")
     * @ORM\Id
     */
    private $urlname;

    /**
     * @var DateTime
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var string
     * @ORM\Column(name="id", type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MeetupEvent", mappedBy="meetupGroup", cascade={"persist", "remove"})
     */
    private $events;

    /**
     * MeetupGroup constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }


    public function setUrlname($urlname)
    {
        $this->urlname = $urlname;

        return $this;
    }

    /**
     * Get urlname
     *
     * @return string
     */
    public function getUrlname()
    {
        return $this->urlname;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }



    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    public function addEvent(MeetupEvent $event) {
        $existing = $this->getEvents()->filter(function(MeetupEvent $e) use ($event) {
           return $e->getId() == $event->getId();
        });
        if ($existing->count() == 1) {
            /** @var MeetupEvent $e */
            $e = $existing->first();
            $e->setTime($event->getTime());
            $e->setYesRsvpCount($event->getYesRsvpCount());
            $e->setWaitlistCount($event->getWaitlistCount());
            $e->setDescription($event->getDescription());
            $e->setLink($event->getLink());
        } else {
            $this->events->add($event);
        }
        $event->setMeetupGroup($this);
    }

}

