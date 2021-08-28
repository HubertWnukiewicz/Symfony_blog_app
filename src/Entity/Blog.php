<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $insert_date;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=BlogComment::class, mappedBy="blog_id")
     */
    private $blogComments;

    public function __construct()
    {
        $this->blogComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getInsertDate(): ?\DateTimeInterface
    {
        return $this->insert_date;
    }

    public function setInsertDate(\DateTimeInterface $insert_date): self
    {
        $this->insert_date = $insert_date;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|BlogComment[]
     */
    public function getBlogComments(): Collection
    {
        return $this->blogComments;
    }

    public function addBlogComment(BlogComment $blogComment): self
    {
        if (!$this->blogComments->contains($blogComment)) {
            $this->blogComments[] = $blogComment;
            $blogComment->setBlogId($this);
        }

        return $this;
    }

    public function removeBlogComment(BlogComment $blogComment): self
    {
        if ($this->blogComments->removeElement($blogComment)) {
            // set the owning side to null (unless already changed)
            if ($blogComment->getBlogId() === $this) {
                $blogComment->setBlogId(null);
            }
        }

        return $this;
    }

}
