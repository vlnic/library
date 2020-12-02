<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\Table(name="books")
 * @ORM\HasLifecycleCallbacks()
 *
 * Class Book
 * @package App\Entity
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string", length=350, nullable=false)
     * @var string
     */
    protected string $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @var string|null
     */
    protected ?string $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", mappedBy="books")
     * @var Collection
     */
    protected Collection $authors;

    /**
     * @ORM\Column(name="created", type="integer", nullable=false)
     * @var int
     */
    protected int $created;

    /**
     * @ORM\Column(name="updated", type="integer", nullable=false)
     * @var int
     */
    protected int $updated;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->authors = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Book
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Book
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function addAuthor(Author $author): self
    {
        $this->getAuthors()->add($author->addBook($this));
        return $this;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onCreated(): void
    {
        $this->created = time();
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }

    /**
     * @ORM\PreFlush()
     */
    public function onUpdated(): void
    {
        $this->updated = time();
    }
}
