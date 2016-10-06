<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reply;
use AppBundle\Entity\Subject;
use AppBundle\Form\Type\ReplyType;
use AppBundle\Form\Type\SubjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(path="/subjects")
 */
class SubjectController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="subject_index")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'subjects' => $this->getDoctrine()->getRepository(Subject::class)->findNotResolved()
        ];
    }

    /**
     * @Route(path="/resolved", methods={"GET"}, name="subject_resolved")
     * @Template()
     */
    public function showResolvedAction()
    {
        return [
            'subjects' => $this->getDoctrine()->getRepository(Subject::class)->findResolved()
        ];
    }

    /**
     * @Route(path="/{id}", methods={"GET", "POST"}, name="subject_show", requirements={"id": "\d+"})
     * @Template()
     */
    public function showAction(Request $request, Subject $subject)
    {
        $reply   = new Reply();
        $reply->setSubject($subject);

        $form = $this->createForm(ReplyType::class, $reply, ['method' => 'POST']);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($reply);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
        }

        return [
            'subject' => $subject,
            'form'    => $form->createView(),
            'replies' => $this->getDoctrine()->getRepository(Reply::class)->findOrderedBySubject($subject)
        ];
    }

    /**
     * @Route(path="/create", methods={"GET", "POST"}, name="subject_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(SubjectType::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($subject = $form->getData());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route(path="/{id}/resolve", methods={"GET"}, name="subject_resolve")
     */
    public function resolveAction(Subject $subject)
    {
        $subject->resolve();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
    }

    /**
     * @Route(path="/{id}/remove", methods={"GET"}, name="subject_remove")
     */
    public function removeAction(Subject $subject)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->getDoctrine()->getManager()->remove($subject);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_index');
    }

    /**
     * @Route(path="/{id}/vote/down", methods={"GET"}, name="subject_vote_down")
     */
    public function voteDownAction(Subject $subject)
    {
        $subject->voteDown();
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($subject->getVotes());
    }

    /**
     * @Route(path="/{id}/vote/up", methods={"GET"}, name="subject_vote_up")
     */
    public function voteUpAction(Subject $subject)
    {
        $subject->voteUp();
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($subject->getVotes());
    }
}
