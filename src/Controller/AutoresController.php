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
    // C1 -> Insertar 1 registro por código
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
    // C2 -> Insertar 1 registro por parámetros
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

    // R1 -> Consultar completo con tabla Bootstrap
    #[Route('/ver-autores', name: 'app_autores_ver')]
    public function verAutores(ManagerRegistry $doctrine): Response
    {
        // Sacamos de la biblioteca de gestión de Registros
        // ManagerRegistry el repositorio de Autores
        $repoAutores = $doctrine->getRepository(Autores::class);
        // Sacamos TODOS los registros
        $autores = $repoAutores->findAll();
        
        return $this->render('autores/autores.html.twig', [
            'controller_name' => 'AutoresController',
            'autores' => $autores,
        ]);
    }


    // U1 -> Actualizar por ID y parámetros
    #[Route('/cambiar-autor/{nif}/{nombre}/{edad}', 
    name: 'app_autores_actualizar')]
    public function cambiarAutor(ManagerRegistry $doctrine,
    string $nif, string $nombre, int $edad): Response
    {
        // Sacamos de la biblioteca de gestión de Registros
        // ManagerRegistry el repositorio de Autores
        $repoAutores = $doctrine->getRepository(Autores::class);
        
        // Buscamos el autor a cambiar
        $autor = $repoAutores->find($nif);

        if($autor == null) {
            echo "Autor NO encontrado";
        } else {
            $autor->setNombre($nombre);
            $autor->setEdad($edad);
            // Guardo el autor modificado
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
        }
        
        // OJO! Redireccionamos la salida.
        // redirectToRoute -> Redireccionar a ruta (name)
        // render -> Renderizar un twig (vista)
        return $this->redirectToRoute('app_autores_ver', [
            'controller_name' => 'Autor Actualizado!',
        ]);
        
        /*
        return $this->render('autores/autores.html.twig', [
            'controller_name' => 'AutoresController',
            //'autores' => $autores,
        ]);
        */
    }

    
}
