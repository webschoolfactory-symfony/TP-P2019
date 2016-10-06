<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reply;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        return new JsonResponse($reply->getVotes());
    }

    /**
     * @Route(path="/{id}/vote/down", methods={"GET"}, name="reply_vote_down")
     */
    public function voteDownAction(Reply $reply)
    {
        $reply->voteDown();
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($reply->getVotes());
    }


    /**
     * @Route(path="/{id}/remove", methods={"GET"}, name="reply_remove")
     */
    public function removeAction(Reply $reply)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $subjectId = $reply->getSubject()->getId();
        $this->getDoctrine()->getManager()->remove($reply);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('subject_show', ['id' => $subjectId]);
    }
}
