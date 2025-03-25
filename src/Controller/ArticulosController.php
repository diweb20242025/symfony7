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

    #[Route('/crear-articulos', 
    name: 'app_articulos_insertar_articulos')]
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
        }




        return $this->render('articulos/index.html.twig', [
            'controller_name' => 'ArticulosController',
        ]);
    }
}
