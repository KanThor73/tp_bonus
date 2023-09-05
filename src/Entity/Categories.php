<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Request;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, options: ['default' => 'aucune' ])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Products::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: SousCategories::class, orphanRemoval: true)]
    private Collection $parent;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategorie($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategorie() === $this) {
                $product->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SousCategories>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(SousCategories $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setCategories($this);
        }

        return $this;
    }

    public function removeParent(SousCategories $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getCategories() === $this) {
                $parent->setCategories(null);
            }
        }

        return $this;
    }


}
