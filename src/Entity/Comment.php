<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $blog_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_visible;

    /**
     * @param $blog_id
     * @param $text
     * @param $is_visible
     */
    public function __construct($blog_id, $text, $is_visible)
    {
        $this->blog_id = $blog_id;
        $this->text = $text;
        $this->is_visible = $is_visible;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogId(): ?int
    {
        return $this->blog_id;
    }

    public function setBlogId(int $blog_id): self
    {
        $this->blog_id = $blog_id;

        return $this;
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

    public function getIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
    }
}
