<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Excerpt
 *
 * @ORM\Table(name="excerpt")
 *
 */
//@ORM\Entity(repositoryClass="AppBundle\Repository\MeetupEventRepository")
class Excerpt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", length=50)
     * @ORM\Id
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
     * @ORM\Column(name="author", type="string", length=255)
     */
    protected $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_published", type="date", nullable=true)
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
     * @ORM\Column(name="url", type="string")
     */
    protected $domain;

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
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublished(): \DateTime
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

    public static function deserializeFromApi(array $apiExcerpt) {

        $excerpt = new self;
        $excerpt->setAuthor($apiExcerpt['author']);
        $excerpt->setUrl($apiExcerpt['url']);
        $excerpt->setDomain($apiExcerpt['domain']);
        $excerpt->setTitle($apiExcerpt['title']);
        $excerpt->setExcerpt($apiExcerpt['excerpt']);
        $excerpt->setLeadImageUrl($apiExcerpt['lead_image_url']);
        if (!empty($apiExcerpt['date_published'])) {
            $timeStamp = '@' . $apiExcerpt['date_published']/1000;
            $time = new \DateTime($timeStamp);
            $time->setTimezone(new \DateTimeZone('Europe/Berlin') );
            $excerpt->setDatePublished($time);
        }

        return $excerpt;
    }

}