<?php
//
//namespace App\Entity\Admin;
//
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * @ORM\Entity(repositoryClass="App\Repository\Admin\CategoryRepository")
// */
//class Category
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="integer", nullable=true)
//     */
//    private $parent_id;
//
//    /**
//     * @ORM\Column(type="string", length=50)
//     */
//    private $title;
//
//    /**
//     * @ORM\Column(type="string", length=30)
//     */
//    private $description;
//
//    /**
//     * @ORM\Column(type="string", length=20, nullable=true)
//     */
//    private $category;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getParentId(): ?int
//    {
//        return $this->parent_id;
//    }
//
//    public function setParentId(?int $parent_id): self
//    {
//        $this->parent_id = $parent_id;
//
//        return $this;
//    }
//
//    public function getTitle(): ?string
//    {
//        return $this->title;
//    }
//
//    public function setTitle(string $title): self
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
//    public function setDescription(string $description): self
//    {
//        $this->description = $description;
//
//        return $this;
//    }
//
//    public function getCategory(): ?string
//    {
//        return $this->category;
//    }
//
//    public function setCategory(?string $category): self
//    {
//        $this->category = $category;
//
//        return $this;
//    }
//}




namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\Product", mappedBy="category")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}
