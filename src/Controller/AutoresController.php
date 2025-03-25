<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Autores;     // Entidad Autores
// Añadimos la biblioteca de gestión de Registros (IMPORTANTE!!)
// De aquí sacaremos el entityManager que es el gestor de Entidades
use Doctrine\Persistence\ManagerRegistry;

final class AutoresController extends AbstractController
{
    #[Route('/autores', name: 'app_autores')]
    public function index(): Response
    {
        return $this->render('autores/index.html.twig', [
            'controller_name' => 'AutoresController',
        ]);
    }

    // Ej1: Inserción con datos en el código
    #[Route('/insertar-autor', name: 'app_autores_insertar_autor1')]
    public function insertarAutor1(ManagerRegistry $doctrine): Response
    {
        // Sacamos el gestor de ENTIDADES del ManagerRegistry
        $entityManager = $doctrine->getManager();
        
        // Creo un autor y lo meto en la tabla
        $autor = new Autores();
        $autor->setNif("12345679B");
        $autor->setNombre("Iván Rodríguez");
        $autor->setEdad(48);
        $autor->setSueldoHora(15.95);

        // Insertamos en la tabla y actualizamos
        $entityManager->persist($autor);
        $entityManager->flush();

        return new Response("<h2> Autor metido con NIF " 
            . $autor->getNif() ." </h2>");
    }

    // Ej2: Inserción con datos en la URL (parámetros)
    #[Route('/insertar-autor/{nif}/{nombre}/{edad}/{sueldo}', 
    name: 'app_autores_insertar_autor2')]
    public function insertarAutor2(ManagerRegistry $doctrine,
    string $nif, string $nombre, int $edad, string $sueldo): Response
    {
        // Sacamos el gestor de ENTIDADES del ManagerRegistry
        $entityManager = $doctrine->getManager();
        
        // Creo un autor y lo meto en la tabla
        $autor = new Autores();
        $autor->setNif($nif);
        $autor->setNombre($nombre);
        $autor->setEdad($edad);
        $autor->setSueldoHora($sueldo);

        // Insertamos en la tabla y actualizamos
        $entityManager->persist($autor);
        $entityManager->flush();

        return new Response("<h2> Autor metido con NIF " 
            . $autor->getNif() ." </h2>");
    }


    
}
