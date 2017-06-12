<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Services\MeetupService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetupController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

    /**
     * @param Request $request
     * @Template()
     */
    public function meetupAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(MeetupEvent::class)
            ->createQueryBuilder('e')
            ->where('e.time > CURRENT_TIMESTAMP()')
            ->orderBy('e.time', 'asc')
            ->getQuery()->execute()
        ;

        return [
            'events' => $events
        ];
    }
}
