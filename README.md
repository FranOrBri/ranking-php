# Reto Técnico ranking de anuncios

Este repositorio contiene la solución al reto técnico de ranking de anuncios, desarrollado en Symfony 6.4 con una
arquitectura hexagonal basada en DDD (Domain-Driven Design) y gestionado mediante Docker Compose y Makefile.

El objetivo del proyecto es procesar y puntuar anuncios según distintas reglas de negocio, almacenando los datos de
forma local mediante ficheros JSON. Puedes consultar los objetivos completos del reto en: [README_OBJETIVOS.md](README_OBJETIVOS.md)

## Instalación
Este comando contiene un conjunto de instrucciones para inicializar todo el proyecto:
```
make init
```

- `make build`: construye el contenedor de Docker
- `make start`: arrancar el contenedor
- `make composer-install`: instala las dependencias dentro del contenedor
- `make cache-clear`: limpia la cache dentro del contenedor
- `make serve-run`: levanta el servidor de Symfony

(Puedes comprobar otros comandos de `Makefile` con `make help`)

## Detalles y explicación

Lo primero ha sido apoyarme en el esqueleto proporcionado por la prueba y hacer algunos ajustes a la configuración de
Docker además de añadir el Makefile para facilitar la gestion del proyecto. Solamente se hace uso de un contenedor de
PHP 8.1 en el que se instalan las extensiones necesarias, composer y Symfony CLI para posteriormente crear el proyecto
de Symfony 6.4.

### Aquitectura
Este es un proyecto API que he decidido afrontar con Arquitectura Hexagonal y DDD (Domain-Driven Design). Esta
es la estructura y disposición de carpetas:

En `Domain`
- Entities: con las entidades del dominio (`Ad` y `Picture`).
- Factories: factorias correspondientes al patrón de diseño Factory Method que proporciona una interfaz para crear objetos.
- Repositories: con las interfaces de los repositorios desacoplados de su implementación.
- ValueObjects: objetos inmutables para aportar integridad a las entidades.
- Services: lógica de dominio.

En `Application`
- DTOs: objetos simples que sirven para transportar datos entre las capas.
- UseCases: para la implementación de la lógica de negocio o casos de uso específicos del sistema.

En `Infrastructure`
- Controllers: con las clases encargadas de gestionar las peticiones a la applicación.
- Repositories: con las implementaciones concretas de las interfaces de la capa de Dominio para el acceso a BD. En mi caso con ficheros JSON.

Las rutas de los controladores estan definidas por medio de un fichero yaml en: `config/routes/ads.yaml`
### Testing
En el directorio: `src/Infrastructure/Repositories/InFile/Data` estan los ficheros que se usan para la "persistencia" de datos. Uno para las
Pictures y otro para los Ad. Hay un archivo de backup (`ads.json.bak`) con datos iniciales proporcionados por la prueba. Tambien he agregado un
fichero `http/ads.http` para poder realizar las disintas llamadas a los endpoints.

Para el testing he realizado un test unitario con PHPUnit del servicio que calcula la puntuación de los anuncios:
`AdScoreCalculator`. Para lanzar los test existe este comando:

```
make test
```
