<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route(path="/{id}", methods={"GET"}, name="subject_show")
     * @Template()
     */
    public function showAction($id)
    {
        return [
            'subject' => $this->getDoctrine()->getRepository(Subject::class)->find($id)
        ];
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
     * @Route(path="/{id}/vote/up", methods={"GET"}, name="subject_vote_down")
     */
    public function voteDownAction(Subject $subject)
    {
        $subject->voteDown();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subject->getId()]);
    }
}
