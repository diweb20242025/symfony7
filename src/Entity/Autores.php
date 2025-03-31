<?php
namespace App\Entity;
use App\Repository\AutoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutoresRepository::class)]
class Autores
{
    #[ORM\Id]
    #[ORM\Column(length: 9)]
    private ?string $nif = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(nullable: true)]
    private ?int $edad = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $sueldoHora = null;

    /**
     * @var Collection<int, Articulos>
     */
    #[ORM\OneToMany(targetEntity: Articulos::class, mappedBy: 'nifAutor')]
    private Collection $articulos;

    public function __construct(){
        $this->articulos = new ArrayCollection();
    }

    public function getNif(): ?string{
        return $this->nif;
    }

    public function setNif(string $nif): static{
        $this->nif = $nif;
        return $this;
    }

    public function getNombre(): ?string{
        return $this->nombre;
    }

    public function setNombre(string $nombre): static{
        $this->nombre = $nombre;
        return $this;
    }

    public function getEdad(): ?int{
        return $this->edad;
    }

    public function setEdad(?int $edad): static{
        $this->edad = $edad;
        return $this;
    }

    public function getSueldoHora(): ?string{
        return $this->sueldoHora;
    }

    public function setSueldoHora(?string $sueldoHora): static{
        $this->sueldoHora = $sueldoHora;
        return $this;
    }

    /**
     * @return Collection<int, Articulos>
     */
    public function getArticulos(): Collection
    {
        return $this->articulos;
    }

    public function addArticulo(Articulos $articulo): static
    {
        if (!$this->articulos->contains($articulo)) {
            $this->articulos->add($articulo);
            $articulo->setNifAutor($this);
        }
        return $this;
    }

    public function removeArticulo(Articulos $articulo): static
    {
        if ($this->articulos->removeElement($articulo)) {
            // set the owning side to null (unless already changed)
            if ($articulo->getNifAutor() === $this) {
                $articulo->setNifAutor(null);
            }
        }
        return $this;
    }
}
