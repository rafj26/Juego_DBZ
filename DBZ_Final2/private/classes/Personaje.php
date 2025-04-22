<?php
/**
 * Clase base abstracta para todos los personajes
 */
abstract class Personaje {
    protected $nombre;
    protected $vida;
    protected $ki;
    protected $vida_maxima;

    /**
     * Constructor de la clase Personaje
     *
     * @param string $nombre Nombre del personaje
     * @param int $vida Vida inicial del personaje
     * @param int $ki Ki inicial del personaje
     */
    public function __construct($nombre, $vida, $ki) {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->vida_maxima = $vida;
        $this->ki = $ki;
    }

    /**
     * Obtiene el nombre del personaje
     *
     * @return string Nombre del personaje
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Obtiene la vida actual del personaje
     *
     * @return int Vida actual
     */
    public function getVida() {
        return $this->vida;
    }
    
    /**
     * Obtiene la vida máxima del personaje
     *
     * @return int Vida máxima
     */
    public function getVidaMaxima() {
        return $this->vida_maxima;
    }

    /**
     * Obtiene el ki actual del personaje
     *
     * @return int Ki actual
     */
    public function getKi() {
        return $this->ki;
    }

    /**
     * Establece el ki del personaje (con límites)
     *
     * @param int $ki Nuevo valor de ki
     */
    public function setKi($ki) {
        $this->ki = max(0, min(100, $ki));
    }

    /**
     * Reduce la vida del personaje al recibir daño
     *
     * @param int $danio Cantidad de daño a recibir
     */
    public function recibirDanio($danio) {
        $this->vida -= $danio;
        if ($this->vida < 0) $this->vida = 0;
    }
    
    /**
     * Cura al personaje por una cantidad determinada
     *
     * @param int $cantidad Cantidad de vida a curar
     * @return int Cantidad real curada
     */
    public function curar($cantidad) {
        $vidaAntes = $this->vida;
        $this->vida = min($this->vida + $cantidad, $this->vida_maxima);
        return $this->vida - $vidaAntes;
    }

    /**
     * Verifica si el personaje está vivo
     *
     * @return bool True si está vivo
     */
    public function estaVivo() {
        return $this->vida > 0;
    }
    
    /**
     * Establece la vida del personaje (con límite máximo)
     *
     * @param int $cantidad Nueva cantidad de vida
     */
    public function setVida($cantidad) {
        $this->vida = min($cantidad, $this->vida_maxima);
    }
}