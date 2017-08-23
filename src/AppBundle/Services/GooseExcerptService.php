<?php


namespace AppBundle\Services;


use AppBundle\Entity\Excerpt;
use DOMWrap\NodeList;
use Goose\Article;
use Goose\Client;

class GooseExcerptService
{

    /**
     * @var Client
     */
    protected $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getExcerpt($url) : Excerpt {

        $article = $this->client->extractContent($url);
        $excerpt = new Excerpt();

        $excerpt->setUrl($article->getFinalUrl());
        $excerpt->setDomain($article->getDomain());
        $excerpt->setTitle($this->extractTitle($article)); //todo: maybe seek 1 h1 / og:title?

        $excerpt->setFullText($article->getCleanedArticleText());

        $excerpt->setExcerpt($this->extractExcerpt($article));

        if(null !== $topImage = $article->getTopImage()) {
            $excerpt->setLeadImageUrl($topImage->getImageSrc());
        }

        if (null != $publishedDate = $this->extractPublishedDate($article)) {
            $excerpt->setDatePublished($publishedDate);
        }

        $author = trim($this->extractAuthor($article));
        $excerpt->setAuthor($author);

        return $excerpt;
    }

    protected function extractAuthor(Article $article) {
        /** @var NodeList $authors */
        /** @var Document $doc */
        $doc = $article->getDoc();
        $authors = $doc->find('meta[property=author]');
        if ($authors->count() > 0) {
            $author =  $authors->get(0)->getAttribute('content');
            return $author;
        }
        $authors = $article->getRawDoc()->find('.author.vcard');
        if ($authors->count() > 0) {
            $author = $authors->get(0)->getText();
            return $author;
        }

        $authors = $article->getRawDoc()->find('a[rel=author]');
        if ($authors->count() > 0) {
            $author =  $authors->get(0)->getText();
            return $author;
        }
        $authors = $article->getRawDoc()->find('meta[itemprop=author]');
        if ($authors->count() > 0) {
            $author =  $authors->get(0)->getAttribute('content');
            return $author;
        }

        $authors = $article->getRawDoc()->find('a[rel="external me"]');
        if ($authors->count() > 0) {
            $author =  $authors->get(0)->getText();
            return $author;
        }
    }

    protected function extractPublishedDate(Article $article) {
        $publishedDate = $article->getPublishDate();
        if ($publishedDate != null)
            return $publishedDate;

        $metas = $article->getRawDoc()->find('meta[itemprop=datePublished]');
        if ($metas->count() > 0) {
            $metaDate =  $metas->get(0)->getAttribute('content');
            if (!empty($metaDate)) {
                return \DateTime::createFromFormat(\DateTime::W3C, $metaDate);
            }
        }

        $abbr = $article->getRawDoc()->find('abbr.published');
        if ($abbr->count() > 0) {
            $_date = $abbr->first()->getAttribute('title');
            if (!empty($_date)) {
                return \DateTime::createFromFormat(\DateTime::W3C, $_date);
            }
        }
    }

    protected function extractExcerpt(Article $article) {
        return $article->getMetaDescription();
    }

    protected function extractTitle(Article $article) {

        if (!empty($article->getOpenGraph())) {
            $og = $article->getOpenGraph();
            if (isset($og['title'])) {
                return $og['title'];
            }
        }

        return $article->getTitle();
    }
}