<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isLocated;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     */
    private $categorised;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="product")
     */
    private $illustratedBy;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="products")
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Auctioneer::class, mappedBy="product")
     */
    private $auction;

    /**
     * @ORM\OneToMany(targetEntity=Bids::class, mappedBy="auction")
     */
    private $bids;

    public function __construct()
    {
        $this->categorised = new ArrayCollection();
        $this->illustratedBy = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->auction = new ArrayCollection();
        $this->bids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getIsLocated(): ?Location
    {
        return $this->isLocated;
    }

    public function setIsLocated(?Location $isLocated): self
    {
        $this->isLocated = $isLocated;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategorised(): Collection
    {
        return $this->categorised;
    }

    public function addCategorised(Category $categorised): self
    {
        if (!$this->categorised->contains($categorised)) {
            $this->categorised[] = $categorised;
        }

        return $this;
    }

    public function removeCategorised(Category $categorised): self
    {
        $this->categorised->removeElement($categorised);

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getIllustratedBy(): Collection
    {
        return $this->illustratedBy;
    }

    public function addIllustratedBy(Images $illustratedBy): self
    {
        if (!$this->illustratedBy->contains($illustratedBy)) {
            $this->illustratedBy[] = $illustratedBy;
            $illustratedBy->setProduct($this);
        }

        return $this;
    }

    public function removeIllustratedBy(Images $illustratedBy): self
    {
        if ($this->illustratedBy->removeElement($illustratedBy)) {
            // set the owning side to null (unless already changed)
            if ($illustratedBy->getProduct() === $this) {
                $illustratedBy->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(User $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
        }

        return $this;
    }

    public function removeFavorite(User $favorite): self
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    /**
     * @return Collection|Auctioneer[]
     */
    public function getAuction(): Collection
    {
        return $this->auction;
    }

    public function addAuction(Auctioneer $auction): self
    {
        if (!$this->auction->contains($auction)) {
            $this->auction[] = $auction;
            $auction->setProduct($this);
        }

        return $this;
    }

    public function removeAuction(Auctioneer $auction): self
    {
        if ($this->auction->removeElement($auction)) {
            // set the owning side to null (unless already changed)
            if ($auction->getProduct() === $this) {
                $auction->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bids[]
     */
    public function getBids(): Collection
    {
        return $this->bids;
    }

    public function addBid(Bids $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids[] = $bid;
            $bid->setAuction($this);
        }

        return $this;
    }

    public function removeBid(Bids $bid): self
    {
        if ($this->bids->removeElement($bid)) {
            // set the owning side to null (unless already changed)
            if ($bid->getAuction() === $this) {
                $bid->setAuction(null);
            }
        }

        return $this;
    }
}
