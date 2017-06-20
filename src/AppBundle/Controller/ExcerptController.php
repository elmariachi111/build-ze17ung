<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Excerpt;
use AppBundle\Form\NewExcerptForm;
use AppBundle\Services\MercuryExcerptService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return [
            'form' => $form->createView(),
            'excerpts' => $repo->findAll()
        ];
    }

    /**
     * @Route("/convert", name="excerpt_convert")
     * @Method("POST")
     *
     * @return Response
     */
    public function convertAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(NewExcerptForm::class,[]);
        $form->handleRequest($request);
        $articleUrl = $form->getData()['url'];

        $excerpt = $this->get(MercuryExcerptService::class)->getExcerpt($articleUrl);
        $em = $this->getDoctrine()->getManager();
        $em->persist($excerpt);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
