<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\NoteRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title = '';

    /**
     * @ORM\Column(type="text")
     */
    private $body = '';

    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, cascade={"persist"}, inversedBy="notes")
     */
    private $tags;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param  string  $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param  \DateTime  $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param  \DateTime  $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return array
     */
    public function getTagNames(): array
    {
        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = $tag->getName();
        }

        return $tags;
    }

    /**
     * @param  Tag  $tag
     * @return $this
     */
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * @param  Tag  $tag
     * @return $this
     */
    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @return $this
     */
    public function removeAllTags(): self
    {
        foreach ($this->tags as $tag) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
