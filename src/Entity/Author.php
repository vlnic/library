<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @ORM\Table(name="authors")
 * @ORM\HasLifecycleCallbacks()
 *
 * Class Author
 * @package App\Entity
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @var string
     */
    protected string $name;

    /**
     * @ORM\Column(name="second_name", type="string", nullable=false)
     * @var string
     */
    protected string $secondName;

    /**
     * @ORM\Column(name="middle_name", type="string", nullable=true)
     * @var string|null
     */
    protected ?string $middleName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="authors")
     * @var Collection
     */
    protected Collection $books;

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
     * Author constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->books = new ArrayCollection();
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
     * @return Author
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
     * @return Author
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return Author
     */
    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function addBook(Book $book)
    {
        $this->getBooks()->add($book->addAuthor($this));
        return $this;
    }

    /**
     * @return Collection
     */
    public function getBooks(): Collection
    {
        return $this->books;
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
