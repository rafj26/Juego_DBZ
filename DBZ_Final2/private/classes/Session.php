<?php
/**
 * Clase para administrar la sesión del juego
 */
class Session {
    /**
     * Inicializa la sesión y limpia si es necesario
     */
    public static function inicializar() {
        session_start();

        // Limpiar sesión corrupta
        if (isset($_SESSION['reset_required'])) {
            session_unset();
            session_destroy();
            session_start();
            unset($_SESSION['reset_required']);
        }
    }
    
    /**
     * Agrega un mensaje al registro
     * 
     * @param string $mensaje El mensaje a agregar
     */
    public static function agregarMensaje($mensaje) {
        if (!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes'] = [];
        }
        $_SESSION['mensajes'][] = $mensaje;
    }
    
    /**
     * Obtiene todos los mensajes
     * 
     * @return array Los mensajes registrados
     */
    public static function obtenerMensajes() {
        return $_SESSION['mensajes'] ?? [];
    }
    
    /**
     * Obtiene el turno actual
     * 
     * @return int El número de turno actual
     */
    public static function obtenerTurno() {
        return $_SESSION['turno'] ?? 1;
    }
    
    /**
     * Incrementa el contador de turno
     */
    public static function incrementarTurno() {
        $_SESSION['turno'] = ($_SESSION['turno'] ?? 1) + 1;
    }
    
    /**
     * Obtiene el número de semillas usadas
     * 
     * @return int Número de semillas usadas
     */
    public static function obtenerSemillasUsadas() {
        return $_SESSION['semillas_usadas'] ?? 0;
    }
    
    /**
     * Establece el número de semillas usadas
     * 
     * @param int $cantidad Número de semillas usadas
     */
    public static function establecerSemillasUsadas($cantidad) {
        $_SESSION['semillas_usadas'] = $cantidad;
    }
    
    /**
     * Establece el guerrero en la sesión
     * 
     * @param GuerreroZ $guerrero El guerrero a establecer
     */
    public static function establecerGuerrero($guerrero) {
        $_SESSION['guerrero'] = $guerrero;
    }
    
    /**
     * Obtiene el guerrero de la sesión
     * 
     * @return GuerreroZ|null El guerrero actual
     */
    public static function obtenerGuerrero() {
        return $_SESSION['guerrero'] ?? null;
    }
    
    /**
     * Establece el villano actual
     * 
     * @param Villano $villano El villano a establecer
     */
    public static function establecerVillanoActual($villano) {
        if ($villano === null) {
            unset($_SESSION['villano_actual']);
        } else {
            $_SESSION['villano_actual'] = $villano;
        }
    }
    
    /**
     * Obtiene el villano actual
     * 
     * @return Villano|null El villano actual
     */
    public static function obtenerVillanoActual() {
        return $_SESSION['villano_actual'] ?? null;
    }
    
    /**
     * Establece la saga actual
     * 
     * @param Saga $saga La saga a establecer
     */
    public static function establecerSaga($saga) {
        $_SESSION['saga'] = $saga;
    }
    
    /**
     * Obtiene la saga actual
     * 
     * @return Saga|null La saga actual
     */
    public static function obtenerSaga() {
        return $_SESSION['saga'] ?? null;
    }
    
    /**
     * Verifica si hay un villano activo en la sesión
     * 
     * @return bool True si hay un villano activo
     */
    public static function hayVillanoActivo() {
        return isset($_SESSION['villano_actual']);
    }
}