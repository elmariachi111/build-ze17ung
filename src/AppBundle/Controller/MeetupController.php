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
            ->where('e.time > :from')
            ->andWhere('e.time < :until')
            ->orderBy('e.time', 'asc')
            ->setParameter(':from', new \DateTime('first day of this month'))
            ->setParameter(':until', new \DateTime('+3 month'))
            ->getQuery()->execute()
        ;

        $groups = $this->getDoctrine()->getRepository(MeetupGroup::class)->findAll();

        return [
            'events' => $events,
            'groups' => $groups

        ];
    }
}
