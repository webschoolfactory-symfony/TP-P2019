<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubjectRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Subject
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $resolved;

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

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $upVote;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $downVote;

    /**
     * @ORM\OneToMany(targetEntity="Reply", mappedBy="subject", cascade={"ALL"})
     *
     * @var Collection<Reply>
     */
    private $replies;

    public function __construct()
    {
        $this->upVote    = $this->downVote = 0;
        $this->resolved  = false;
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
        $this->replies   = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function resolve()
    {
        $this->resolved = true;
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

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isResolved()
    {
        return $this->resolved;
    }

    /**
     * @param boolean $resolved
     */
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;
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
     * @return Collection<Reply>
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;
    }
}
