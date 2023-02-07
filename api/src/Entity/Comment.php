<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\CreateTimeTrait;
use App\Entity\Traits\UpdateTimeTrait;
use App\Entity\Traits\UuidTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasyRdf\Container;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    normalizationContext: ['groups' => 'read', 'enable_max_depth' => true],
    denormalizationContext: ['groups' => 'write'],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id'               => 'exact',
    'topicId'          => 'exact',
    'replyToCommentId' => 'exact',
    'topCommentId'     => 'exact',
])]
#[ApiFilter(DateFilter::class, properties: [
    'createTime',
    'updateTime',
])]
#[Orm\HasLifecycleCallbacks()]
#[Orm\Entity]
class Comment
{
    use UuidTrait;
    use CreateTimeTrait;
    use UpdateTimeTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[Groups(['read','write'])]
    private int $id;

    #[ORM\Column(type: 'uuid_binary')]
    #[Groups(['read'])]
    private UuidInterface $uuid;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read', 'write'])]
    private ?int $topicId;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read', 'write'])]
    private ?int $replyToCommentId;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read', 'write'])]
    private ?int $topCommentId;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read', 'write'])]
    private ?int $userId;

    #[ORM\Column(type: 'string')]
    #[Groups(['read', 'write'])]
    private string $title;

    #[ORM\Column(type: 'string')]
    #[Groups(['read', 'write'])]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read'])]
    private DateTime $createTime;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read'])]
    private ?DateTime $updateTime;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'subComments')]
    #[ORM\JoinColumn(name: 'reply_to_comment_id')]
    #[Groups(['write'])]
    private ?Comment $replyToComment;


    #[ORM\OneToMany(
        mappedBy: 'replyToComment',
        targetEntity: Comment::class,
        cascade: ['persist'],
        orphanRemoval: true
    )]
    #[Groups(['read', 'write'])]
    private ?Collection $subComments;


    public function __construct()
    {
        $this->subComments = new ArrayCollection();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTopicId(): ?int
    {
        return $this->topicId;
    }

    public function setTopicId($topicId): static
    {
        $this->topicId = $topicId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getReplyToCommentId(): ?int
    {
        return $this->replyToCommentId;
    }

    public function setReplyToCommentId($replyToCommentId): static
    {
        $this->replyToCommentId = $replyToCommentId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTopCommentId(): ?int
    {
        return $this->topCommentId;
    }

    public function setTopCommentId($topCommentId): static
    {
        $this->topCommentId = $topCommentId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId($userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreateTime(): DateTime
    {
        return $this->createTime;
    }

    public function setCreateTime($createTime): static
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdateTime(): ?DateTime
    {
        return $this->updateTime;
    }

    public function setUpdateTime($updateTime): static
    {
        $this->updateTime = $updateTime;

        return $this;
    }


    /**
     * @return Collection<int, Comment>
     */
    public function getSubComments(): Collection
    {
        return $this->subComments;
    }

    public function addSubComment(Comment $subComment): static
    {
        if (!$this->subComments->contains($subComment)) {
            $this->subComments[] = $subComment;
            $subComment->setReplyToComment($this);
        }

        return $this;
    }

    public function removeSubComment(Comment $subComment): static
    {
        $this->subComments->removeElement($subComment);

        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getReplyToComment(): ?Comment
    {
        return $this->replyToComment;
    }

    public function setReplyToComment($replyToComment): static
    {
        $this->replyToComment = $replyToComment;

        return $this;
    }


}
