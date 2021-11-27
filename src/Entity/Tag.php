<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=20)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, mappedBy="tags")
     */
    private $notes;


    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * @param  Note  $note
     * @return $this
     */
    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addTag($this);
        }
        return $this;
    }

    /**
     * @param  Note  $note
     * @return $this
     */
    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            $note->removeTag($this);
        }
        return $this;
    }
}
