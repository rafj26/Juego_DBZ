<?php
/**
 * Clase para la lógica principal del juego
 */
class Game {
    /**
     * Crea un nuevo jefe (villano)
     *
     * @param string $nombre Nombre del jefe
     * @param int $vida Vida inicial
     * @param int $ki Ki inicial
     * @param string $habilidad Habilidad especial
     * @return Villano Instancia del villano creado
     */
    public static function crearJefe($nombre, $vida, $ki, $habilidad) {
        return new Villano($nombre, $vida, $ki, $habilidad);
    }
    
    /**
     * Reinicia completamente el juego
     */
    public static function reiniciarJuego() {
        // Crear guerrero
        $guerrero = new GuerreroZ("Goku", 200, 100);
        
        // Crear saga con jefes
        $saga = new Saga("Saga de Freezer", [
            self::crearJefe("Freezer", 150, 50, "Rayo de la Muerte"),
            self::crearJefe("Cell Perfecto", 200, 70, "Absorción"),
            self::crearJefe("Majin Buu", 300, 100, "Explosión Malvada")
        ]);
        
        // Guardar en sesión
        Session::establecerGuerrero($guerrero);
        Session::establecerSaga($saga);
        
        // Inicializar variables
        $_SESSION['turno'] = 1;
        $_SESSION['mensajes'] = [];
        $_SESSION['semillas_usadas'] = 0;
        Session::establecerVillanoActual(null);
    }
}