Dragon Ball RPG
Un juego de rol por turnos basado en Dragon Ball Z utilizando programación orientada a objetos en PHP.
Descripción
Este proyecto implementa un juego de rol por turnos donde el jugador controla a Goku y debe enfrentarse a diferentes villanos de Dragon Ball Z. El código ha sido reorganizado para seguir buenas prácticas de programación orientada a objetos y mantener una estructura modular.
Características principales

Sistema de combate por turnos
Transformaciones de Super Saiyan
Tres villanos principales: Freezer, Cell Perfecto y Majin Buu
Habilidades especiales para Goku
Sistema de energía (Ki) y vida
Uso de semillas del ermitaño para recuperación

Estructura del Proyecto
dragon_ball_rpg/
│
├── index.php                 # Archivo principal (controlador y vista)
│
├── .htacces
│
├── public/
│   └── assets/
│   │   └── css/
│   │       └── style.css         # Estilos CSS
│   │
│   └──  img/                      # Directorio para imágenes
│        ├── normal.png            # Goku normal
│        ├── ssj1.png              # Goku SSJ1
│        ├── ssj2.png              # Goku SSJ2
│        ├── ssj3.png              # Goku SSJ3
│        ├── freezer.png           # Freezer
│        ├── cell.jpg              # Cell Perfecto
│        ├── mjboo.png             # Majin Buu
│        ├── insecto.webp          # Imagen de derrota
│
├── private/
    └── classes/                  # Clases del sistema
    ├── Session.php           # Manejo de sesión
    ├── Personaje.php         # Clase base para personajes
    ├── GuerreroZ.php         # Clase para el Guerrero Z (Goku)
    ├── Villano.php           # Clase para Villanos
    ├── Saga.php              # Gestión de la saga con villanos
    └── Game.php              # Lógica principal del juego
Conceptos de Programación Implementados
Programación Orientada a Objetos

Abstracción: La clase Personaje define una estructura abstracta para todos los personajes.
Herencia: Las clases GuerreroZ y Villano heredan de la clase base Personaje.
Encapsulamiento: Las propiedades de las clases están encapsuladas para acceder a través de métodos.
Polimorfismo: El método atacar() se implementa de forma diferente en cada clase.

Patrones de Diseño

Singleton (conceptual): La clase Session implementa conceptos similares a un Singleton para manejar el estado global del juego.
Facade (simplificado): La clase Game ofrece una interfaz simplificada para la creación de personajes y gestión del juego.

Cómo jugar

Instala el juego en un servidor con PHP (versión 7.0+ recomendada)
Accede a index.php desde tu navegador
Controla a Goku usando las opciones disponibles:

Transformarte para aumentar tu poder
Atacar usando diferentes habilidades
Cargar KI para recuperar energía
Usar semillas del ermitaño cuando estés en peligro


Vence a todos los villanos para ganar

Requisitos del Sistema

PHP 7.0 o superior
Servidor web (Apache, Nginx, etc.)
Soporte para sesiones PHP
Navegador web moderno con JavaScript habilitado

Instalación

Clona o descarga este repositorio
Crea la estructura de directorios como se indica arriba
Coloca cada archivo en su ubicación correspondiente
Asegúrate de tener las imágenes necesarias en la carpeta img/
Accede a través del navegador

Personalización
Puedes personalizar el juego de diversas formas:

Añadir más villanos en la clase Game.php
Crear nuevas habilidades para Goku en GuerreroZ.php
Modificar los estilos en style.css
Cambiar las imágenes en la carpeta img/

Créditos
Este juego es un proyecto educativo para demostrar conceptos de programación orientada a objetos en PHP. Los personajes y elementos de Dragon Ball Z son propiedad de sus respectivos dueños.
