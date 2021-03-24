<?php


namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=TodoListRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class TodoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="description", type="string", nullable=false, length=100, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="important", type="boolean", nullable=true, options={"default":0})
     */
    private $important = 0;

    /**
     * @ORM\Column(name="completed", type="boolean", nullable=true, options={"default":0})
     */
    private $completed = 0;

    /**
     * @ORM\Column(name="deleted", type="boolean", nullable=true, options={"default":0})
     */
    private $deleted = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @ORM\Version
     * @var DateTime
     */
    protected $deletedAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setCreatedAtValue(): void
    {
        $dateTime = new \DateTimeImmutable();
        $this->setUpdatedAt($dateTime);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTime);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImportant(): ?bool
    {
        return $this->important;
    }

    public function setImportant(?bool $important): self
    {
        $this->important = $important;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getDelete(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->completed = $deleted;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updated): self
    {
        $this->updatedAt = $updated;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $created): self
    {
        $this->createdAt = $created;

        return $this;
    }
}
