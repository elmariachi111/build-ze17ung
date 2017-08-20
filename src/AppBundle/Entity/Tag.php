<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 */

class Tag
{
    /**
     * @var string $slug
     * @ORM\Id
     * @ORM\Column(name="slug", type="string", unique=true)
     */
    protected $slug;

    /**
     * @var string $name
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string $color
     * @ORM\Column(name="color", type="string", length=7, nullable=true)
     */
    protected $color;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Excerpt", mappedBy="tags")
     */
    protected $excerpts;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\MeetupGroup", mappedBy="tags")
     */
    protected $meetupGroups;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->excerpts = new ArrayCollection();
        $this->meetupGroups = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color)
    {
        $this->color = $color;
    }


    /**
     * @return mixed
     */
    public function getExcerpts()
    {
        return $this->excerpts;
    }

    /**
     * @param mixed $excerpts
     */
    public function setExcerpts($excerpts)
    {
        $this->excerpts = $excerpts;
    }

    /**
     * @return mixed
     */
    public function getMeetupGroups()
    {
        return $this->meetupGroups;
    }

    /**
     * @param mixed $meetupGroups
     */
    public function setMeetupGroups($meetupGroups)
    {
        $this->meetupGroups = $meetupGroups;
    }

    public function addMeetupGroup(MeetupGroup $meetupGroup) {
        $this->meetupGroups[] = $meetupGroup;
    }

    public function addExcerpt(Excerpt $excerpt) {
        $this->excerpts[] = $excerpt;
    }

    public function removeExcerpt(Excerpt $excerpt) {
        $this->excerpts->removeElement($excerpt);
    }


}