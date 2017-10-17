<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceRepository")
 * @ORM\Table(name="conferences")
 */
class Conference
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="text", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     * @ORM\Column(name="starts", type="datetime")
     */
    private $starts;

    /**
     * @var \DateTime
     * @ORM\Column(name="ends", type="datetime", nullable=true)
     */
    private $ends;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var  string
     * @ORM\Column(name="source", type="string", length=80, nullable=true)
     */
    private $source;

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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="conferences")
     * @ORM\JoinTable(name="conferences_tags",
     *     joinColumns={@ORM\JoinColumn(name="conference_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_slug", referencedColumnName="slug")}
     * )
     */
    protected $tags;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getStarts()
    {
        return $this->starts;
    }

    /**
     * @param \DateTime $starts
     */
    public function setStarts(\DateTime $starts)
    {
        $this->starts = $starts;
    }

    /**
     * @return \DateTime
     */
    public function getEnds()
    {
        return $this->ends;
    }

    /**
     * @param \DateTime $ends
     */
    public function setEnds(\DateTime $ends)
    {
        $this->ends = $ends;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * @return array
     */
    public function getVenueLocation(): array
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
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param  $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function addTag(Tag $tag) {
        $this->tags->add($tag);
        $tag->addConference($this);
    }

    public function isPast() {
        return ($this->getEnds() < new \DateTime());
    }

}