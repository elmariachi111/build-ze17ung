<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MeetupEvent", mappedBy="meetupGroup")
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
        $this->events->add($event);
    }

}

