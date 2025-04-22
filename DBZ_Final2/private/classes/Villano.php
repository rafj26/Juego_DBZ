<?php
/**
 * Clase que representa a un Villano
 */
class Villano extends Personaje {
    private $habilidad;

    /**
     * Constructor de la clase Villano
     *
     * @param string $nombre Nombre del villano
     * @param int $vida Vida inicial del villano
     * @param int $ki Ki inicial del villano
     * @param string $habilidad Habilidad especial del villano
     */
    public function __construct($nombre, $vida, $ki, $habilidad) {
        parent::__construct($nombre, $vida, $ki);
        $this->habilidad = $habilidad;
    }

    /**
     * Realiza un ataque contra el objetivo
     *
     * @param GuerreroZ $objetivo Personaje objetivo del ataque
     */
    public function atacar(GuerreroZ $objetivo) {
        $danio = rand(10, 30);
        $vidaAntes = $objetivo->getVida();
        $objetivo->recibirDanio($danio);
        $vidaDespues = $objetivo->getVida();
        
        Session::agregarMensaje("Turno ".Session::obtenerTurno().": ".$this->nombre." ataca (Vida de Goku: $vidaAntes → $vidaDespues)");
        
        Session::incrementarTurno();
    }
    
    /**
     * Obtiene la habilidad especial del villano
     *
     * @return string Nombre de la habilidad especial
     */
    public function getHabilidad() {
        return $this->habilidad;
    }
}