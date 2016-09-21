<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reply;
use AppBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route(path="/{id}", methods={"GET", "POST"}, name="subject_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $reply   = new Reply();
        $reply->setSubject($subject);
        $form = $this->createFormBuilder($reply, ['method' => 'POST'])
            ->add('text')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($reply);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
        }

        return ['subject' => $subject, 'form' => $form->createView()];
    }

    /**
     * @Route(path="/{id}/vote/up", methods={"GET"}, name="subject_vote_up")
     */
    public function voteUpAction(Subject $subject)
    {
        $subject->voteUp();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
    }

    /**
     * @Route(path="/{id}/vote/down", methods={"GET"}, name="subject_vote_down")
     */
    public function voteDownAction(Subject $subject)
    {
        $subject->voteDown();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
    }
}
