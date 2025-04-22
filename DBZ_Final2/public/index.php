<?php
    /**
 * Dragon Ball RPG
 * Archivo principal que actúa como controlador y vista
 */

 $rootPath = dirname(__FILE__); // Ruta del archivo actual
 $privatePath = dirname($rootPath) . '/private'; // Un nivel arriba, luego carpeta private
 define('CLASSES_PATH', $privatePath . '/classes');
 
 // Para depuración, puedes ver la ruta (puedes quitar esto después)
 // echo "Ruta de clases: " . CLASSES_PATH . "<br>";
 
 // Verifica si el directorio existe
 if (!is_dir(CLASSES_PATH)) {
     die("Error: El directorio de clases no existe en: " . CLASSES_PATH);
 }
 
 // Incluir clases desde su nueva ubicación
 require_once CLASSES_PATH . '/Session.php';
 require_once CLASSES_PATH . '/Personaje.php';
 require_once CLASSES_PATH . '/GuerreroZ.php';
 require_once CLASSES_PATH . '/Villano.php';
 require_once CLASSES_PATH . '/Saga.php';
 require_once CLASSES_PATH . '/Game.php';
 

// Cargar clases
/*require_once 'classes/Session.php';
require_once 'classes/Personaje.php';
require_once 'classes/GuerreroZ.php';
require_once 'classes/Villano.php';
require_once 'classes/Saga.php';
require_once 'classes/Game.php';
*/

// Inicializar sesión
Session::inicializar();

// Manejador de reinicio
if (isset($_POST['reiniciar'])) {
    $_SESSION['reset_required'] = true;
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Iniciar juego si no existe sesión
if (!isset($_SESSION['guerrero'])) {
    Game::reiniciarJuego();
}

$guerrero = Session::obtenerGuerrero();
$saga = Session::obtenerSaga();

if (!Session::hayVillanoActivo()) {
    $saga->iniciarSaga();
}

$villano = Session::obtenerVillanoActual();

// Manejar acciones del usuario
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'transformar') {
        $guerrero->transformar();
        Session::establecerGuerrero($guerrero);
    } 
    elseif ($_POST['accion'] == 'semilla_ermitano') {
        $guerrero->usarSemillaErmitano();
        Session::establecerGuerrero($guerrero);
    }
    elseif ($_POST['accion'] == 'atacar' && isset($_POST['habilidad']) && $villano) {
        // Log para depuración
        Session::agregarMensaje("Intentando usar " . $_POST['habilidad'] . " con KI actual: " . $guerrero->getKi());
        
        $guerrero->atacar($_POST['habilidad'], $villano);
        
        // Log después del ataque
        Session::agregarMensaje("KI después del ataque: " . $guerrero->getKi());
        
        Session::establecerGuerrero($guerrero);
        Session::establecerVillanoActual($villano);
        
        if ($villano->estaVivo()) {
            $villano->atacar($guerrero);
            Session::establecerGuerrero($guerrero);
            Session::establecerVillanoActual($villano);
        } else {
            $saga->siguienteJefe();
            $villano = Session::obtenerVillanoActual();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon Ball RPG</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Dragon Ball Z - RPG</h1>

        <div class="battle-area">
            <?php 
            $claseAura = '';
            if ($guerrero->getNivelSSJ() > 0) {
                $claseAura = 'aura-ssj';
                $claseAura .= ' ssj' . $guerrero->getNivelSSJ();
            }
            ?>
            <div class="character-card <?= $claseAura ?>">
                <h2>Guerrero Z</h2>
                
                <!-- Imagen de Goku que cambia según el nivel SSJ -->
                <?php
                $imagenGoku = 'img/normal.png'; // Goku base por defecto
                
                if ($guerrero->getNivelSSJ() == 1) {
                    $imagenGoku = 'img/ssj1.png';
                } elseif ($guerrero->getNivelSSJ() == 2) {
                    $imagenGoku = 'img/ssj2.png';
                } elseif ($guerrero->getNivelSSJ() == 3) {
                    $imagenGoku = 'img/ssj3.png';
                }
                ?>
                <img src="<?= $imagenGoku ?>" alt="Goku" class="character-image">
                <?php if ($guerrero->getNivelSSJ() > 0): ?>
                    <div class="ssj-level">SSJ<?= $guerrero->getNivelSSJ() ?></div>
                <?php endif; ?>
                
                <p><strong>Nombre:</strong> <?= htmlspecialchars($guerrero->getNombre()) ?></p>
                <p><strong>Vida:</strong></p>
                <div class="barra">
                    <div class="vida" style="width: <?= ($guerrero->getVida()/200)*100 ?>%"></div>
                    <div class="texto-barra"><?= $guerrero->getVida() ?> / 200</div>
                </div>
                
                <p><strong>KI:</strong></p>
                <div class="barra">
                    <div class="ki" style="width: <?= $guerrero->getKi() ?>%"></div>
                    <div class="texto-barra"><?= $guerrero->getKi() ?> / 100</div>
                </div>
                
                <p><strong>Transformación:</strong> SSJ<?= $guerrero->getNivelSSJ() ?></p>
                <?php if (isset($_SESSION['semillas_usadas'])): ?>
                <p><strong>Semillas usadas:</strong> <?= Session::obtenerSemillasUsadas() ?>/2</p>
                <?php endif; ?>
            </div>

            <?php if ($villano): ?>
            <div class="character-card">
                <h2>Villano</h2>
                
                <!-- Imagenes de villanos -->
                <?php
                $nombreVillano = strtolower($villano->getNombre());
                
                // Para saber que villano mostrar en la pantalla
                $imagenVillano = '';
                if ($nombreVillano == 'freezer') {
                    $imagenVillano = 'img/freezer.png';
                } elseif ($nombreVillano == 'cell perfecto') {
                    $imagenVillano = 'img/cell.jpg';
                } elseif ($nombreVillano == 'majin buu') {
                    $imagenVillano = 'img/mjboo.png';
                }
                ?>
                <img src="<?= $imagenVillano ?>" alt="<?= htmlspecialchars($villano->getNombre()) ?>" class="character-image">
                
                <p><strong>Nombre:</strong> <?= htmlspecialchars($villano->getNombre()) ?></p>
                <p><strong>Vida:</strong></p>
                <div class="barra">
                    <div class="vida" style="width: <?= ($villano->getVida()/$villano->getVidaMaxima())*100 ?>%"></div>
                    <div class="texto-barra"><?= $villano->getVida() ?> / <?= $villano->getVidaMaxima() ?></div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Área de mensajes - Mostrando los más recientes primero -->
        <div class="mensajes">
            <?php foreach(array_reverse(Session::obtenerMensajes()) as $mensaje): ?>
                <p><?= htmlspecialchars($mensaje) ?></p>
            <?php endforeach; ?>
        </div>

        <?php if ($guerrero->estaVivo() && $villano): ?>
        <div class="controls">
            <div class="action-group">
                <div class="action-title">Acciones Especiales</div>
                <div class="button-group">
                    <form method="post">
                        <button type="submit" name="accion" value="transformar" class="transformar-button"
                            <?= ($guerrero->getNivelSSJ() >= 3 || $guerrero->getKi() < 50) ? 'disabled' : '' ?>>
                            Transformar (50 KI) - Cura 50 de Vida
                        </button>
                    </form>
                    
                    <?php if ($guerrero->puedeUsarSemilla()): ?>
                    <form method="post">
                        <?php $claseSemilla = Session::obtenerSemillasUsadas() == 1 ? 'semilla-button semilla-segunda' : 'semilla-button'; ?>
                        <button type="submit" name="accion" value="semilla_ermitano" class="<?= $claseSemilla ?>">
                            <?= $guerrero->getDescripcionSemilla() ?>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="action-group">
                <div class="action-title">Ataques</div>
                <div class="button-group">
                    <?php foreach($guerrero->getHabilidadesDisponibles() as $nombre => $detalles): 
                        $costo = $detalles['costo'];
                        $costoDisplay = $costo < 0 ? '+'.abs($costo) : $costo;
                        
                        // Determinar la clase del botón según el ataque
                        $buttonClass = 'ataque-button';
                        if ($nombre == 'Cargar KI') {
                            $buttonClass = 'cargar-button';
                        } elseif ($nombre == 'Genkidama') {
                            $buttonClass = 'genkidama-button';
                        }
                        ?>
                        <form method="post">
                            <input type="hidden" name="accion" value="atacar">
                            <input type="hidden" name="habilidad" value="<?= htmlspecialchars($nombre) ?>">
                            <button type="submit" class="<?= $buttonClass ?>"
                                <?= ($costo > 0 && $guerrero->getKi() < $costo) ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($nombre) ?> (<?= $costoDisplay ?> KI)
                                <?php if ($nombre == 'Genkidama'): ?> - 100 de daño<?php endif; ?>
                            </button>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php elseif (!$guerrero->estaVivo()): ?>
            <div class="game-over">
                <h2>¡¡¡HAS SIDO DERROTADO INSECTO, INTENTALO OTRA VEZ!!!</h2>
                <img src="img/insecto.webp" alt="Derrota" class="derrota-imagen">
            </div>
        <?php else: ?>
            <div class="game-over victory">
                <h2>¡Victoria! Todos los villanos han sido derrotados</h2>
            </div>
        <?php endif; ?>

        <form method="post">
            <button type="submit" name="reiniciar" class="reiniciar-button">Reiniciar Juego</button>
        </form>
    </div>
</body>
</html>