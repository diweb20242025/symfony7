<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Articulos;   // Entidad Articulos
use App\Entity\Autores;     // OJO! Poner también la principal
use Doctrine\Persistence\ManagerRegistry;
// Vamos a meter directamente el repositorio
use App\Repository\ArticulosRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ArticulosController extends AbstractController
{
    #[Route('/articulos', name: 'app_articulos')]
    public function index(): Response
    {
        return $this->render('articulos/index.html.twig', [
            'controller_name' => 'ArticulosController',
        ]);
    }

    // C3 -> Insertar varios registros (array) por código
    // OJO, hay que tener cuidado con el registro tabla principal
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

    // C4 -> Insertar 1 registro por parámetros
    // Variante C2. Controlamos dato tabla principal
    #[Route('/crea-articulo/{titulo}/{publicado}/{nif}',
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

    // R2 -> Consultar completo tabla relacionada con Bootstrap
    // OJO! Mirar el twig articulos.html.twig!!
    #[Route('/ver-articulos', name: 'app_articulos_ver')]
    public function verArticulos(ArticulosRepository $repo): Response
    {
        $articulos = $repo->findAll();

        return $this->render('articulos/articulos.html.twig', [
            'controller_name' => 'ArticulosController',
            'articulos' => $articulos,
        ]);
    }

    // R3a -> Consultar por Clave Principal
    // Pongo esta ruta en el routes.yaml /mostrar-articulo/{id}
    #[Route('/ver-articulo/{id}', 
    name: 'app_articulos_ver_articulo')]
    public function verArticulo(ArticulosRepository $repo,
    int $id): Response
    {
        $articulo = $repo->find($id);

        return $this->render('articulos/articulos.html.twig', [
            'controller_name' => 'ArticulosController',
            'articulos' => [$articulo],
        ]);
    }

    // R4 -> Consultar por parámetros. Salida Array JSON!
    #[Route('/consultar-articulos/{nifAutor}/{publicado}', 
    name: 'app_articulos_consultar_articulos')]
    public function consultarArticulos(ArticulosRepository $repo,
    string $nifAutor, bool $publicado): JsonResponse
    {
        $articulos = $repo->findBy(
            [
                'nifAutor' => $nifAutor,
                'publicado' => $publicado
            ],
            [
                'titulo' => 'DESC'  // DESC | ASC
            ]
        );

        // Aquí la salida NO es twig. Es JSON!!!!
        
        $miJSON = [];
        foreach ($articulos as $articulo) {
            $miJSON[] = [
                'idArticulo' => $articulo->getId(),
                'Titulo' => $articulo->getTitulo(),
                'Nif Autor' => $articulo->getNifAutor()->getNif(),
                'Nombre Autor' => $articulo->getNifAutor()->getNombre(),
            ];
        }

        return new JsonResponse($miJSON);
        
        // Si queremos devolver una tabla con twig
        /*
        return $this->render('articulos/articulos.html.twig', [
            'controller_name' => 'ArticulosController',
            'articulos' => $articulos,
        ]);
        */
    }


    // R5 -> Consultar por parámetros. Salida 1 Registro JSON!
    #[Route('/consultar-articulo/{nifAutor}', 
    name: 'app_articulos_consultar_articulo')]
    public function consultarArticulo(ArticulosRepository $repo,
    string $nifAutor): JsonResponse
    {
        $articulo = $repo->findOneBy(
            [
                'nifAutor' => $nifAutor,
            ],
            [
                'titulo' => 'DESC'  // DESC | ASC
            ]
        );

        // Aquí la salida NO es twig. Es JSON!!!!
        
        if($articulo == null) {
            $miJSON = "Articulo no encontrado";
        } else {
            $miJSON = [
                'idArticulo' => $articulo->getId(),
                'Titulo' => $articulo->getTitulo(),
                'Nif Autor' => $articulo->getNifAutor()->getNif(),
                'Nombre Autor' => $articulo->getNifAutor()->getNombre(),
            ];
        }
        
        return new JsonResponse($miJSON);
        
        // Si queremos devolver una tabla con twig
        /*
        return $this->render('articulos/articulos.html.twig', [
            'controller_name' => 'ArticulosController',
            'articulos' => [$articulo],
        ]);
        */
    }
}
