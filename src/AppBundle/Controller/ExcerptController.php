<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Excerpt;
use AppBundle\Entity\Tag;
use AppBundle\Form\NewExcerptForm;
use AppBundle\Services\MercuryExcerptService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     *
     * @Template()
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository(Excerpt::class);
        $form = $this->createForm(NewExcerptForm::class,[], [
            'action' => $this->generateUrl('excerpt_convert')
        ]);
        $excerpts = $repo->findBy([], ['id' => 'DESC']);
        return [
            'form' => $form->createView(),
            'excerpts' => $excerpts
        ];
    }

    /**
     * @Route("/convert", name="excerpt_convert")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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
     * @Route("/{id}/tag", name="excerpt_modify_tag")
     * @Method({"POST","DELETE"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @return Response
     */
    public function tagExcerptAction($id, Request $request) {
        $slug = $request->get('slug', null);
        if ($slug == null)
            throw new BadRequestHttpException("You must provide a slug");

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

        return $this->redirectToRoute('homepage');
    }
}