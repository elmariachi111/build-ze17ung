<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//@ORM\Entity(repositoryClass="AppBundle\Repository\MeetupEventRepository")

/**
 * @ORM\Entity()
 * @ORM\Table(name="excerpt")
 */
class Excerpt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_published", type="datetime", nullable=true)
     */
    protected $datePublished;

    /**
     * @var string
     *
     * @ORM\Column(name="lead_image_url", type="string", nullable=true)
     */
    protected $leadImageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="excerpt", type="text", nullable=true)
     */
    protected $excerpt;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", unique=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string")
     */
    protected $domain;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="excerpts")
     * @ORM\JoinTable(name="excerpts_tags",
     *     joinColumns={@ORM\JoinColumn(name="excerpt_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_slug", referencedColumnName="slug")}
     * )
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
    public function getTitle(): string
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
     * @return string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     */
    public function setDatePublished(\DateTime $datePublished)
    {
        $this->datePublished = $datePublished;
    }

    /**
     * @return string
     */
    public function getLeadImageUrl(): string
    {
        return $this->leadImageUrl;
    }

    /**
     * @param string $leadImageUrl
     */
    public function setLeadImageUrl(string $leadImageUrl)
    {
        $this->leadImageUrl = $leadImageUrl;
    }

    public function getOwnedLeadImageUrl() : string
    {
        $options = ['type' => 'fetch'];
        $fetched = cloudinary_url_internal($this->getLeadImageUrl(), $options);
        return $fetched;
    }
    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     */
    public function setExcerpt(string $excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * @return string
     */
    public function getUrl(): string
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
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Collection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }


    public function addTag(Tag $tag) {
        $this->tags->add($tag);
        $tag->addExcerpt($this);
    }

    public static function deserializeFromApi(array $apiExcerpt) {

        $excerpt = new self;
        $excerpt->setAuthor($apiExcerpt['author']);
        $excerpt->setUrl($apiExcerpt['url']);
        $excerpt->setDomain($apiExcerpt['domain']);
        $excerpt->setTitle($apiExcerpt['title']);
        $excerpt->setExcerpt($apiExcerpt['excerpt']);
        $excerpt->setLeadImageUrl($apiExcerpt['lead_image_url']);
        if (!empty($apiExcerpt['date_published'])) {
            $time = new \DateTime($apiExcerpt['date_published']);
            $excerpt->setDatePublished($time);
        }

        return $excerpt;
    }

}