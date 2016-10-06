<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reply;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route(path="/replies")
 */
class ReplyController extends Controller
{
    /**
     * @Route(path="/{id}/vote/up", methods={"GET"}, name="reply_vote_up")
     */
    public function voteUpAction(Reply $reply)
    {
        $reply->voteUp();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $reply->getSubject()->getId()]);
    }

    /**
     * @Route(path="/{id}/vote/down", methods={"GET"}, name="reply_vote_down")
     */
    public function voteDownAction(Reply $reply)
    {
        $reply->voteDown();
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $reply->getSubject()->getId()]);
    }


    /**
     * @Route(path="/{id}/remove", methods={"GET"}, name="reply_remove")
     */
    public function removeAction(Reply $reply)
    {
        $subjectId = $reply->getSubject()->getId();
        $this->getDoctrine()->getManager()->remove($reply);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subjectId]);
    }
}
