<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conference;
use AppBundle\Form\NewConferenceForm;
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

        $form = $this->createForm(NewConferenceForm::class, new Conference(), [
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
        $form = $this->createForm(NewConferenceForm::class, $conference, [

        ]);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $em->persist($conference);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
