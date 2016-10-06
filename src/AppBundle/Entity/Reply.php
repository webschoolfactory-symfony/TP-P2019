<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReplyRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class Reply
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="replies")
     *
     * @var Subject
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $author;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $upVote;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $downVote;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->upVote = $this->downVote = 0;
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param Subject $subject
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getVotes()
    {
        return $this->upVote - $this->downVote;
    }

    public function isVoteNegative()
    {
        return $this->downVote > $this->upVote;
    }

    public function voteUp()
    {
        $this->upVote++;
    }

    public function voteDown()
    {
        $this->downVote++;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;
    }
}
