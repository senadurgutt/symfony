<?php
//
//namespace App\Entity\Admin;
//
//use App\Repository\Admin\ProductRepository;
//use Doctrine\ORM\Mapping as ORM;
//use App\Entity\Member;
//use App\Entity\Admin\Category;
///**
// * @ORM\Entity(repositoryClass=ProductRepository::class)
// */
//class Product
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $title;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $description;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $member;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $image;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Category")
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $category;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getTitle(): ?string
//    {
//        return $this->title;
//    }
//
//    public function setTitle(?string $title): self
//    {
//        $this->title = $title;
//
//        return $this;
//    }
//
//    public function getDescription(): ?string
//    {
//        return $this->description;
//    }
//
//    public function setDescription(?string $description): self
//    {
//        $this->description = $description;
//
//        return $this;
//    }
//
//    public function getMember(): ?Member
//    {
//        return $this->member;
//    }
//
//    public function setMember(?Member $member): self
//    {
//        $this->member = $member;
//        return $this;
//    }
//
//    public function getImage(): ?string
//    {
//        return $this->image;
//    }
//
//    public function setImage(?string $image): self
//    {
//        $this->image = $image;
//
//        return $this;
//    }
//
//    public function getCategory(): ?Category
//    {
//        return $this->category;
//    }
//
//    public function setCategory(?Category $category): self
//    {
//        $this->category = $category;
//        return $this;
//    }
//}


namespace App\Entity\Admin;

use App\Repository\Admin\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Member;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=145, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
     * @ORM\JoinColumn(nullable=true)
     */
    private $member;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
