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

### Endpoints de Inserción

Autores (tabla principal):
- http://localhost:8000/autores
- [C1] http://localhost:8000/insertar-autor
- [C2] http://localhost:8000/insertar-autor/{nif}/{nombre}/{edad}/{sueldo}
- http://localhost:8000/insertar-autor/11223344F/Iván/48/15.50

Articulos (tabla relacionada): 
- [C3] http://localhost:8000/crear-articulos
- [C4] http://localhost:8000/crea-articulo/{titulo}/{publicado}/{nif}
- http://localhost:8000/crea-articulo/"PRL Acabado!"/1/12345678B.0

### Endpoints de Consulta


Autores (tabla principal):
- [R1] http://localhost:8000/ver-autores

Articulos (tabla relacionada):
- [R2] http://localhost:8000/ver-articulos
- [R3a] http://localhost:8000/ver-articulo/{id}
- [R3b] http://localhost:8000/mostrar-articulo/{id}
- [R4] http://localhost:8000/consultar-articulos/{nifAutor}/{publicado}
- [R5] http://localhost:8000/consultar-articulo/{nifAutor}

### Endpoints de Actualización

- [U1] http://localhost:8000/cambiar-autor/{nif}/{nombre}/{edad}
- [U2] http://localhost:8000/cambiar-articulo/{id}/{titulo}/{nifAutor}

### Endpoints de Eliminación

- [D1] http://localhost:8000/articulo-borrar/{id}

### Endpoints de Formularios

- [F1] http://localhost:8000/articulos-form
- [F2] http://localhost:8000/autores-form


### Métodos por defecto de los repositorios


- Métodos por defecto de los Repositorios
  - findAll() -> SELECT * FROM "tabla" => array registros
    Ej: SELECT * FROM autores;

  - findBy($criterios, $ordenacion, $limite, $salto)
    - $criterios -> Conjunto de filtros (WHERE)
    - $ordenación -> Conjunto de ordenaciones
    - $limite -> Nº de registros a mostrar
    - $salto -> Registros por intervalos
      - Ejemplo: Tenemos 500 autores 
  ({nif}/{nombre}/{edad}/{sueldo})
  SELECT * FROM autores
  WHERE edad > 40       -> $criterio1
  AND sueldo > 20       -> $criterio2
  LIMIT 10              -> $limite
  OFFSET 40             -> $salto
  ORDER BY sueldo ASC;  -> $ordenación
        
  - find($id) -> SELECT * FROM "tabla" WHERE clave = "" -> 1 registro
    Ej: SELECT * FROM autores WHERE nif = 12345678B

  - findOneBy ($criterios, $ordenacion) -> 1 registro
    Ej: SELECT * FROM autores
        WHERE name = "pepito"
        AND edad = 78;
