<?php

namespace App\Controller;

// Inyecciones de clases externas (dependencias)
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AleatorioController extends AbstractController
{
    // Anotación PHP () -> PHP8 (Nov2020)
    #[Route('/num-aleatorio', name: 'app_aleatorio1')]
    public function index(): Response
    {
        return $this->render('aleatorio/index.html.twig', [
            'controller_name' => 'AleatorioController',
        ]);
    }

    // La forma previa a Symfony7 usaba @route
    //@Route("/otro-aleatorio", name="app_aleatorio2")
    // Esta no renderiza, responde con un HTML puro
    #[Route('/otro-aleatorio', name: 'app_aleatorio2')]
    public function mialeatorio(): Response
    {
        $aleatorio = random_int(1,100);
        return new Response("<h2>Aleatorio = $aleatorio</h2>");
    }

    // http://127.0.0.1:8000/aleatorio
    #[Route('/aleatorio', name: 'app_aleatorio3')]
    public function mialeatorio2(): Response
    {
        $aleatorio1 = random_int(1,100);
        $aleatorio2 = random_int(1,100);
        return $this->render('aleatorio/aleatorio.html.twig', [
            'controller_name' => 'AleatorioController',
            'numero_aleatorio1' => $aleatorio1,
            'numero_aleatorio2' => $aleatorio2,
        ]);
    }

    // Defino la ruta usando el archivo routes.yaml
    // El archivo está en /config/routes.yaml
    public function mialeatorio3(): Response
    {
        $aleatorio1 = random_int(1,50);
        $aleatorio2 = random_int(51,100);
        return $this->render('aleatorio/aleatorio.html.twig', [
            'controller_name' => 'AleatorioController',
            'numero_aleatorio1' => $aleatorio1,
            'numero_aleatorio2' => $aleatorio2,
        ]);
    }
}
