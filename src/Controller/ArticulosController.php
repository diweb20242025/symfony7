<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Articulos;   // Entidad Articulos
use App\Entity\Autores;     // OJO! Poner también la principal
use Doctrine\Persistence\ManagerRegistry;

final class ArticulosController extends AbstractController
{
    #[Route('/articulos', name: 'app_articulos')]
    public function index(): Response
    {
        return $this->render('articulos/index.html.twig', [
            'controller_name' => 'ArticulosController',
        ]);
    }

    #[Route(
        '/crear-articulos',
        name: 'app_articulos_insertar_articulos'
    )]
    public function crearArticulos(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        // Definimos un array de artículos
        $articulos = [
            "articulo1" => [
                "titulo" => "Creador de Symfony",
                "publicado" => 1,
                "nifAutor" => "12345678B"
            ],
            "articulo2" => [
                "titulo" => "Concentración Alumnos 0",
                "publicado" => 1,
                "nifAutor" => "12345678B"
            ],
            "articulo3" => [
                "titulo" => "Prácticas en Empresa: Ofú!",
                "publicado" => 1,
                "nifAutor" => "12345678B"
            ],
        ];

        // Uso un foreach para recorrer el array
        // Y meto en la tabla artículo por artículo
        foreach ($articulos as $articulo) {
            $nuevoArticulo = new Articulos();
            $nuevoArticulo->setTitulo($articulo['titulo']);
            $nuevoArticulo->setPublicado($articulo['publicado']);

            // Tengo que poner el objeto de la tabla principal
            // Para ello uso el repositorio de Autores
            $nif = $entityManager->getRepository
            (Autores::class)->find($articulo['nifAutor']);
            $nuevoArticulo->setNifAutor($nif);

            $entityManager->persist($nuevoArticulo);
            $entityManager->flush();
        }

        return new Response("<h2> Artículos metidos</h2>");
    }

    #[Route(
        '/crea-articulo/{titulo}/{publicado}/{nif}',
        name: 'app_articulos_insertar_articulo'
    )]
    public function creaArticulo(ManagerRegistry $doctrine,
    string $titulo, int $publicado, string $nif): Response
    {
        $entityManager = $doctrine->getManager();
        $nuevoArticulo = new Articulos();
        $nuevoArticulo->setTitulo($titulo);
        $nuevoArticulo->setPublicado($publicado);
        // Vamos a controlar que el NIF existe
        $mensaje = "";
        $nif = $entityManager->getRepository
        (Autores::class)->find($nif);

        if($nif==null) {
            $mensaje = "ERROR! No existe el autor";
        } else {
            $nuevoArticulo->setNifAutor($nif);
            $entityManager->persist($nuevoArticulo);
            $entityManager->flush();
            $mensaje = "EXITO! Se ha introducido el artículo.";
        }

        return new Response("<h2> $mensaje </h2>");
    }
}
