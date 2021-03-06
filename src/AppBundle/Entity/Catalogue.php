<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Catalogue
 *
 * @ORM\Table(name="catalogue")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("isbn")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatalogueRepository")
 */
class Catalogue
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
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=20, unique=true)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="category_id", type="integer")
     */
    //private $categoryId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="catalogue")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="catalogue")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment_thumb", type="string", length=255)
     */
    private $attachmentThumb;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment_file", type="string", length=255)
     */
    private $attachmentFile;

    /**
     * @var string
     *
     * @ORM\Column(name="catalogue_type", type="string", length=15)
     */
    private $catalogueType;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

	/**
	 *
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function updatedTimestamps()
	{
		$this->setModifiedAt(new \DateTime('now'));

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
     * @return Catalogue
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
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return Catalogue
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Catalogue
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Catalogue
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Catalogue
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Catalogue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Catalogue
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set attachmentThumb
     *
     * @param string $attachmentThumb
     *
     * @return Catalogue
     */
    public function setAttachmentThumb($attachmentThumb)
    {
        $this->attachmentThumb = $attachmentThumb;

        return $this;
    }

    /**
     * Get attachmentThumb
     *
     * @return string
     */
    public function getAttachmentThumb()
    {
        return $this->attachmentThumb;
    }

    /**
     * Set attachmentFile
     *
     * @param string $attachmentFile
     *
     * @return Catalogue
     */
    public function setAttachmentFile($attachmentFile)
    {
        $this->attachmentFile = $attachmentFile;

        return $this;
    }

    /**
     * Get attachmentFile
     *
     * @return string
     */
    public function getAttachmentFile()
    {
        return $this->attachmentFile;
    }

    /**
     * Set catalogueType
     *
     * @param string $catalogueType
     *
     * @return Catalogue
     */
    public function setCatalogueType($catalogueType)
    {
        $this->catalogueType = $catalogueType;

        return $this;
    }

    /**
     * Get catalogueType
     *
     * @return string
     */
    public function getCatalogueType()
    {
        return $this->catalogueType;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Catalogue
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Catalogue
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Catalogue
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
}
