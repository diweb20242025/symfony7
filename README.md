<!-- README.md -->
# symfony7

## Comandos
- symfony serve
- php bin/console doctrine:database:drop --force
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

## Endpoints
- http://localhost:8000/

Aleatorio:
- http://localhost:8000/num-aleatorio
- http://localhost:8000/otro-aleatorio
- http://localhost:8000/aleatorio
- http://localhost:8000/mi_aleatorio_44
  
- http://localhost:8000/autores
- http://localhost:8000/insertar-autor
  
Autores:
- http://localhost:8000/insertar-autor/{nif}/{nombre}/{edad}/{sueldo}
- http://localhost:8000/insertar-autor/11223344F/Iván/48/15.50

Articulos: 
- http://localhost:8000/crear-articulos
- http://localhost:8000/crea-articulo/{titulo}/{publicado}/{nif}
- http://localhost:8000/crea-articulo/"PRL Acabado!"/1/12345678B