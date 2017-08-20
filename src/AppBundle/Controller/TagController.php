<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Excerpt;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tag_index")
     * @Template
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $template = $request->get('template');
        /** @var EntityRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Tag::class);

        if ('_navbar' == $template) {
            $limit = $request->get('limit', 10);

            $qb = $repo->createQueryBuilder('t')
                ->select('t, COUNT(t) as HIDDEN c')
                ->leftJoin('t.excerpts', 'ex', Join::LEFT_JOIN)
                ->groupBy('t.slug')
                ->orderBy('c', 'DESC')
                ->setMaxResults($limit);

            $tags = $qb->getQuery()->execute();
        } else {
            $tags = $repo->findAll();
        }

        $ctx = [
            'currentTag' => $this->get('request_stack')->getMasterRequest()->get('tag',null),
            'tags' => $tags
        ];

        if ($template) {
            return $this->render("AppBundle:Tag:$template.html.twig", $ctx);
        } else {
            return $ctx;
        }
    }

    /**
     * @Route("/{tag}", name="tag_show")
     * @Template()
     */
    public function showAction($tag) {
        return [
            'tag' => $tag
        ];
    }
}
