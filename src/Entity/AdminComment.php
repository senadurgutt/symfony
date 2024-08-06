<?php
//namespace App\Entity;
//
//use App\Repository\AdminCommentRepository;
//use Doctrine\ORM\Mapping as ORM;
//use App\Entity\Admin\Product;
//
///**
// * @ORM\Entity(repositoryClass=AdminCommentRepository::class)
// */
//class AdminComment
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=150)
//     */
//    private $comment;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="comments")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $user;
//
//    /**
//     * @ORM\Column(type="datetime_immutable")
//     */
//    private $createdAt;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Product", inversedBy="comments")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $product;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getComment(): ?string
//    {
//        return $this->comment;
//    }
//
//    public function setComment(string $comment): self
//    {
//        $this->comment = $comment;
//        return $this;
//    }
//
//    public function getUser(): ?Member
//    {
//        return $this->user;
//    }
//
//    public function setUser(?Member $user): self
//    {
//        $this->user = $user;
//        return $this;
//    }
//
//    public function getCreatedAt(): ?\DateTimeImmutable
//    {
//        return $this->createdAt;
//    }
//
//    public function setCreatedAt(\DateTimeImmutable $createdAt): self
//    {
//        $this->createdAt = $createdAt;
//        return $this;
//    }
//
//    public function getProduct(): ?Product
//    {
//        return $this->product;
//    }
//
//    public function setProduct(?Product $product): self
//    {
//        $this->product = $product;
//        return $this;
//    }
//}



namespace App\Entity;

use App\Repository\AdminCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Admin\Product;
use App\Entity\Member;

/**
 * @ORM\Entity(repositoryClass=AdminCommentRepository::class)
 */
class AdminComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="comments")
     * @ORM\JoinColumn(name="userid", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Product", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?Member
    {
        return $this->user;
    }

    public function setUser(?Member $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
