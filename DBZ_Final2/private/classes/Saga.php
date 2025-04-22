<?php
/**
 * Clase para gestionar las sagas del juego
 */
class Saga {
    private $nombre;
    private $jefes;
    private $jefe_actual = 0;

    /**
     * Constructor de la clase Saga
     *
     * @param string $nombre Nombre de la saga
     * @param array $jefes Lista de jefes (villanos) de la saga
     */
    public function __construct($nombre, $jefes) {
        $this->nombre = $nombre;
        $this->jefes = $jefes;
    }

    /**
     * Inicia la saga asignando el primer jefe
     */
    public function iniciarSaga() {
        Session::establecerVillanoActual($this->jefes[$this->jefe_actual]);
        Session::agregarMensaje("Comienza la saga: " . $this->nombre);
    }

    /**
     * Avanza al siguiente jefe de la saga
     * Cura parcialmente al guerrero tras derrotar un jefe
     */
    public function siguienteJefe() {
        // Curar al guerrero por el 25% de su vida actual al derrotar a un villano
        $guerrero = Session::obtenerGuerrero();
        $vidaAntes = $guerrero->getVida();
        
        // Calculamos el 25% de su vida actual
        $cantidadCuracion = ceil($guerrero->getVida() * 0.25);
        $cantidadRealCurada = $guerrero->curar($cantidadCuracion);
        
        $vidaDespues = $guerrero->getVida();
        Session::agregarMensaje("¡Victoria! " . $guerrero->getNombre() . " recupera energía. (Vida: $vidaAntes → $vidaDespues)");
        
        // Actualizar el guerrero en la sesión
        Session::establecerGuerrero($guerrero);
        
        // Avanzar al siguiente jefe
        $this->jefe_actual++;
        if ($this->jefe_actual < count($this->jefes)) {
            Session::establecerVillanoActual($this->jefes[$this->jefe_actual]);
            Session::agregarMensaje("Aparece el siguiente villano: " . $this->jefes[$this->jefe_actual]->getNombre());
        } else {
            Session::agregarMensaje("¡Has vencido a todos los villanos!");
            Session::establecerVillanoActual(null);
        }
    }
    
    /**
     * Obtiene el nombre de la saga
     *
     * @return string Nombre de la saga
     */
    public function getNombre() {
        return $this->nombre;
    }
}