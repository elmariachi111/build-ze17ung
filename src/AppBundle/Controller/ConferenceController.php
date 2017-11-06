<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceForm;
use AppBundle\Repository\ConferenceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/conference")
 */
class ConferenceController extends Controller
{
    /**
     * @Route("/", name="conference_index")
     * @Method("GET")
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /** @var ConferenceRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Conference::class);

        $form = $this->createForm(ConferenceForm::class, new Conference(), [
            'action' => $this->generateUrl('conference_new')
        ]);

        return [
            'conferences' => $repo->getUpcomingConferences(),
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/new", name="conference_new")
     * @Method("POST")
     *
     */
    public function newConferenceAction(Request $request) {

        $conference = new Conference();
        $form = $this->createForm(ConferenceForm::class, $conference, [

        ]);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $em->persist($conference);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->render('@App/Conference/row.html.twig', ['conference' => $conference]);
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/{id}", name="conference_edit")
     * @Method({"GET", "POST"})
     *
     */
    public function editConferenceAction(Request $request, $id) {

        $conference = $this->getDoctrine()->getRepository(Conference::class)->find($id);

        $form = $this->createForm(ConferenceForm::class, $conference, [
            'action' => $this->generateUrl('conference_edit', ['id' => $id])
        ]);

        if ($request->getMethod() == Request::METHOD_GET) {
            return $this->render('@App/Conference/form.html.twig', ['form' => $form->createView()]);
        } else {
            $form->handleRequest($request);
            $this->getDoctrine()->getManager()->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->render('@App/Conference/row.html.twig', ['conference' => $conference]);
            } else {
                return $this->redirectToRoute('homepage');
            }
        }
    }


}
