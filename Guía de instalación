# Guía de Instalación: Dragon Ball RPG

Esta guía te ayudará paso a paso a instalar y configurar el juego Dragon Ball RPG en tu servidor.

## Paso 1: Preparar los Directorios

Crea la siguiente estructura de directorios en tu servidor web:

```
dragon_ball_rpg/
│
├── assets/
│   └── css/
│
├── classes/
│
└── img/
```

## Paso 2: Copiar los Archivos

### Archivos de Clases
Coloca los siguientes archivos en la carpeta `classes/`:

1. `Personaje.php` - Clase abstracta base
2. `GuerreroZ.php` - Clase para Goku
3. `Villano.php` - Clase para los villanos
4. `Saga.php` - Clase para gestionar la saga
5. `Game.php` - Clase para la lógica del juego
6. `Session.php` - Clase para gestionar las sesiones

### Archivos CSS
Coloca el archivo `style.css` en la carpeta `assets/css/`.

### Archivo Principal
Coloca el archivo `index.php` en la raíz del directorio `dragon_ball_rpg/`.

## Paso 3: Imágenes Necesarias

Necesitarás las siguientes imágenes en la carpeta `img/`:

- `normal.png` - Goku en estado normal
- `ssj1.png` - Goku en SSJ1
- `ssj2.png` - Goku en SSJ2
- `ssj3.png` - Goku en SSJ3
- `freezer.png` - Freezer
- `cell.jpg` - Cell Perfecto
- `mjboo.png` - Majin Buu
- `insecto.webp` - Imagen para la pantalla de derrota
- `bg.jpg` - (Opcional) Fondo para el juego

## Paso 4: Configuración del Servidor

### Para Apache
Si usas Apache, asegúrate de que el módulo `mod_rewrite` esté habilitado.

### Para PHP
Verifica que las sesiones de PHP estén habilitadas en tu `php.ini`:

```
session.auto_start = 0
session.use_cookies = 1
session.use_only_cookies = 1
```

## Paso 5: Permisos de Archivos

Configura los permisos adecuados:

```bash
chmod 755 dragon_ball_rpg/
chmod 644 dragon_ball_rpg/*.php
chmod -R 755 dragon_ball_rpg/classes/
chmod -R 755 dragon_ball_rpg/assets/
chmod -R 755 dragon_ball_rpg/img/
```

## Paso 6: Prueba el Juego

Accede a tu juego a través del navegador:

```
http://tu-servidor/dragon_ball_rpg/
```

Deberías ver la pantalla principal del juego con Goku y el primer villano (Freezer).

## Solución de Problemas

### Problemas Comunes

1. **No se ven las imágenes**
   - Verifica que las imágenes estén en la carpeta `img/` y que tengan los nombres correctos.
   - Comprueba los permisos de la carpeta de imágenes.

2. **Errores de sesión**
   - Asegúrate de que PHP tenga permisos para escribir en el directorio de sesiones.
   - Verifica la configuración de sesiones en tu `php.ini`.

3. **Errores de PHP**
   - Activa el modo de depuración añadiendo estas líneas al inicio de `index.php`:
     ```php
     ini_set('display_errors', 1);
     ini_set('display_startup_errors', 1);
     error_reporting(E_ALL);
     ```

4. **Problema con los archivos de clase**
   - Comprueba que todas las clases estén incluidas en el orden correcto.
   - Verifica que los nombres de los archivos coincidan con las clases que contienen.

## Notas Adicionales

- El juego usa sesiones de PHP para guardar el estado del juego, así que asegúrate de no cerrar el navegador si quieres continuar una partida.
- Si encuentras algún error, puedes reiniciar el juego usando el botón "Reiniciar Juego".
- Para desarrollo y pruebas, puedes usar un entorno local como XAMPP, WAMP o MAMP.

¡Disfruta del juego!
