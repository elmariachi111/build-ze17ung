<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MeetupEvent;
use AppBundle\Entity\MeetupGroup;
use AppBundle\Entity\Security\User;
use AppBundle\Entity\Tag;
use AppBundle\Form\NewMeetupGroupForm;
use AppBundle\Services\MeetupService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/meetup")
 */
class MeetupController extends Controller
{
    /**
     * @param Request $request
     * @Template()
     */
    public function meetupAction(Request $request)
    {
        $from = new \DateTime('first day of this month');
        $to = new \DateTime('+3 month');

        $events = $this->getDoctrine()->getRepository(MeetupEvent::class)
            ->createQueryBuilder('e')
            ->where('e.time > :from')
            ->andWhere('e.time < :until')
            ->orderBy('e.time', 'asc')
            ->setParameter(':from', $from)
            ->setParameter(':until', $to)
            ->getQuery()->execute()
        ;

        $groups = $this->getDoctrine()->getRepository(MeetupGroup::class)->findAll();

        $form = $this->createForm(NewMeetupGroupForm::class,[], [
            'action' => $this->generateUrl('meetup_new')
        ]);

        return [
            'events' => $events,
            'groups' => $groups,
            'range' => ['from' => $from, 'to' => $to],
            'form'  => $form->createView()
        ];
    }

    /**
     * @Route("/new", name="meetup_new")
     * @Method("POST")
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     *
     * @Template()
     */
    public function newMeetupAction(Request $request, UserInterface $user) {

        $form = $this->createForm(NewMeetupGroupForm::class,[]);

        $form->handleRequest($request);
        $meetupData = $form->getData();
        $meetupUrl = $meetupData['url'];

        $path = parse_url($meetupUrl, PHP_URL_PATH);
        $parts = explode('/',$path);
        $groupUrlAlias = $parts[1];

        $em = $this->getDoctrine()->getManager();

        $group = $em->getRepository(MeetupGroup::class)->find($groupUrlAlias);
        if (!$group) {
            $group = $this->get(MeetupService::class)->getMeetupGroup($groupUrlAlias);
            $em->merge($group);
            $em->flush();
        }

        $events = $this->get(MeetupService::class)->syncEvents($group);
        foreach($events as $event) {
            $em->merge($event);
        }

        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{id}/tag", name="meetupgroup_modify_tag")
     * @Method({"POST","DELETE"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @return  Response
     */
    public function tagMeetupGroupAction($id, Request $request) {
        $slug = $request->get('slug', null);
        if ($slug == null)
            throw new BadRequestHttpException();

        $em = $this->getDoctrine()->getManager();

        $group = $em->getRepository(MeetupGroup::class)->find($id);

        $tag = $em->getRepository(Tag::class)->find($slug);
        if ($tag == null) {
            $tag = new Tag();
            $tag->setSlug($slug);
            $em->persist($tag);
        }
        $group->addTag($tag);

        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
