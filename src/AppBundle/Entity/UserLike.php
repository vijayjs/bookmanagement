<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLike
 *
 * @ORM\Table(name="user_like")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserLikeRepository")
 */
class UserLike
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userlike")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="userlike")
     * @ORM\JoinColumn(name="catelogue_id", referencedColumnName="id")
     */
    private $catelogue;

	/**
	 *
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function updatedTimestamps()
	{
		if ($this->getCreatedAt() == null) {
			$this->setCreatedAt(new \DateTime('now'));
		}
	}

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserLike
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserLike
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set catelogueId
     *
     * @param integer $catelogueId
     *
     * @return UserLike
     */
    public function setCatelogueId($catelogueId)
    {
        $this->catelogueId = $catelogueId;

        return $this;
    }

    /**
     * Get catelogueId
     *
     * @return int
     */
    public function getCatelogueId()
    {
        return $this->catelogueId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserLike
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set catelogue
     *
     * @param \AppBundle\Entity\Catalogue $catelogue
     *
     * @return UserLike
     */
    public function setCatelogue(\AppBundle\Entity\Catalogue $catelogue = null)
    {
        $this->catelogue = $catelogue;

        return $this;
    }

    /**
     * Get catelogue
     *
     * @return \AppBundle\Entity\Catalogue
     */
    public function getCatelogue()
    {
        return $this->catelogue;
    }
}
