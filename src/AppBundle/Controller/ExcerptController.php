<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Excerpt;
use AppBundle\Entity\Tag;
use AppBundle\Form\NewExcerptForm;
use AppBundle\Repository\ExcerptRepository;
use AppBundle\Services\MercuryExcerptService;
use Doctrine\ORM\Query\Expr\Join;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/excerpt")
 */
class ExcerptController extends Controller
{
    /**
     * @Route("/", name="excerpt_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var ExcerptRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Excerpt::class);
        $form = $this->createForm(NewExcerptForm::class,[], [
            'action' => $this->generateUrl('excerpt_convert')
        ]);
        $tag = $request->get('tag', null);

        $limit = $request->get('limit', 25);
        $offset = $request->get('offset', 0);
        $template = $request->get('template', 'index');
        $before = $request->get('before', null);

        $qb = $repo->createQueryBuilder('e')
            ->setMaxResults($limit)
            ->orderBy('e.id', 'DESC');

        if ($tag) {
            $qb->leftJoin('e.tags', 't', Join::LEFT_JOIN)
               ->andWhere('t = :tag')
               ->setParameter('tag', $tag);
        }

        if ($before) {
            $qb->andWhere($qb->expr()->lt('e.id', $before));
        } else {
            $qb->setFirstResult($offset);
        }

        $excerpts = $qb->getQuery()->execute();

        return $this->render("AppBundle:Excerpt:$template.html.twig",[
            'form' => $form->createView(),
            'excerpts' => $excerpts,
            'tag' => $tag
        ]);
    }

    /**
     * @Route("/convert", name="excerpt_convert")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @return Response
     */
    public function convertAction(Request $request)
    {
        $form = $this->createForm(NewExcerptForm::class,[]);
        $form->handleRequest($request);
        $articleUrl = $form->getData()['url'];

        $excerpt = $this->get(MercuryExcerptService::class)->getExcerpt($articleUrl);
        $em = $this->getDoctrine()->getManager();
        $em->persist($excerpt);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * xhr
     *
     * @Route("/{id}/tag/{slug}", name="excerpt_add_tag")
     * @Method({"PUT"})
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @return Response
     */
    public function tagExcerptAction($id, $slug = null) {

        $em = $this->getDoctrine()->getManager();

        $excerpt = $em->getRepository(Excerpt::class)->find($id);

        $tag = $em->getRepository(Tag::class)->find($slug);
        if ($tag == null) {
            $tag = new Tag();
            $tag->setSlug($slug);
            $em->persist($tag);
        }
        $excerpt->addTag($tag);

        $em->flush();

        return new JsonResponse([
            'slug' => $tag->getSlug()
        ]);
    }

    /**
     * xhr
     *
     * @Route("/{id}/tag/{slug}", name="excerpt_delete_tag")
     * @Method({"DELETE"})
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @return Response
     */
    public function deleteTagExcerptAction($id, $slug = null) {

        $em = $this->getDoctrine()->getManager();

        $excerpt = $em->getRepository(Excerpt::class)->find($id);

        $tag = $em->getRepository(Tag::class)->find($slug);
        if ($tag != null) {
            $excerpt->removeTag($tag);
        }

        $em->flush();

        return new JsonResponse([
            'slug' => $tag->getSlug()
        ]);
    }
}
