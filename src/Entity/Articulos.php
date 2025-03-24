<?php

namespace App\Entity;

use App\Repository\ArticulosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticulosRepository::class)]
class Articulos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?bool $publicado = null;

    #[ORM\ManyToOne(inversedBy: 'articulos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Autores $nifAutor = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function isPublicado(): ?bool
    {
        return $this->publicado;
    }

    public function setPublicado(bool $publicado): static
    {
        $this->publicado = $publicado;

        return $this;
    }

    public function getNifAutor(): ?Autores
    {
        return $this->nifAutor;
    }

    public function setNifAutor(?Autores $nifAutor): static
    {
        $this->nifAutor = $nifAutor;

        return $this;
    }

}
