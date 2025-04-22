<?php
/**
 * Clase que representa a un Guerrero Z (como Goku)
 */
class GuerreroZ extends Personaje {
    private $nivel_ssj;
    private $habilidades;

    /**
     * Constructor de la clase GuerreroZ
     *
     * @param string $nombre Nombre del guerrero
     * @param int $vida Vida inicial del guerrero
     * @param int $ki Ki inicial del guerrero
     */
    public function __construct($nombre, $vida, $ki) {
        parent::__construct($nombre, $vida, $ki);
        $this->nivel_ssj = 0;
        $this->habilidades = [
            'Kamehameha' => ['danio' => 50, 'costo' => 20, 'requiere_ssj' => 0],
            'Ataque Rápido' => ['danio' => 30, 'costo' => 10, 'requiere_ssj' => 0],
            'Genkidama' => ['danio' => 100, 'costo' => 80, 'requiere_ssj' => 3],
            'Cargar KI' => ['danio' => 0, 'costo' => -20, 'requiere_ssj' => 0],
        ];
    }

    /**
     * Transforma al guerrero Z para aumentar su nivel SSJ
     */
    public function transformar() {
        if ($this->nivel_ssj < 3 && $this->ki >= 50) {
            // Registrar vida antes de curar
            $vidaAntes = $this->vida;
            
            // Transformar y gastar KI
            $this->nivel_ssj++;
            $this->setKi($this->ki - 50);
            
            // Curar 50 puntos de vida
            $this->curar(50);
            
            // Registrar vida después de curar
            $vidaDespues = $this->vida;
            
            Session::agregarMensaje("¡Transformación SSJ{$this->nivel_ssj} completada! (Vida: $vidaAntes → $vidaDespues)");
        }
    }

    /**
     * Realiza un ataque o usa una habilidad
     *
     * @param string $habilidad Nombre de la habilidad a usar
     * @param Villano $objetivo Objetivo del ataque
     */
    public function atacar($habilidad, Villano $objetivo) {
        if (!isset($this->habilidades[$habilidad])) {
            Session::agregarMensaje("ERROR: Habilidad no encontrada");
            return;
        }

        $detalles = $this->habilidades[$habilidad];
        if ($this->nivel_ssj < $detalles['requiere_ssj']) {
            Session::agregarMensaje("ERROR: Nivel SSJ insuficiente");
            return;
        }

        // Verificar si podemos usar la habilidad según su costo de KI
        if ($detalles['costo'] < 0) {
            // Es "Cargar KI", siempre se puede usar
            $kiAntes = $this->ki;
            $this->setKi($this->ki + abs($detalles['costo']));
            $kiDespues = $this->ki;
            Session::agregarMensaje("Turno ".Session::obtenerTurno().": ".$this->nombre." usa ".$habilidad." (KI: $kiAntes → $kiDespues)");
            Session::incrementarTurno();
        } 
        else if ($this->ki >= $detalles['costo']) {
            // Es un ataque con costo positivo
            $kiAntes = $this->ki;
            $this->setKi($this->ki - $detalles['costo']);
            $kiDespues = $this->ki;
            
            // Calcular y aplicar daño al objetivo
            $danio = $detalles['danio'];
            $vidaAntes = $objetivo->getVida();
            $objetivo->recibirDanio($danio);
            $vidaDespues = $objetivo->getVida();
            
            Session::agregarMensaje("Turno ".Session::obtenerTurno().": ".$this->nombre." usa ".$habilidad." (KI: $kiAntes → $kiDespues, Vida de ".$objetivo->getNombre().": $vidaAntes → $vidaDespues)");
            Session::incrementarTurno();
        } else {
            Session::agregarMensaje("ERROR: KI insuficiente para usar ".$habilidad);
        }
    }
    
    /**
     * Utiliza una semilla del ermitaño para recuperar vida y KI
     */
    public function usarSemillaErmitano() {
        $vidaAntes = $this->vida;
        $kiAntes = $this->ki;
        
        // Determinar si es primera o segunda semilla
        if (!Session::obtenerSemillasUsadas() || Session::obtenerSemillasUsadas() == 0) {
            // Primera semilla: restaura a 180 de vida y Ki al máximo
            $this->setVida(180);
            $this->setKi(100);
            Session::establecerSemillasUsadas(1);
            Session::agregarMensaje("Turno ".Session::obtenerTurno().": ".$this->nombre." usa la primera Semilla del Ermitaño (Vida: $vidaAntes → ".$this->vida.", KI: $kiAntes → ".$this->ki.")");
        } else {
            // Segunda semilla: restaura 100 de vida y +50 de Ki
            $this->curar(100);
            $this->setKi(min(100, $this->ki + 50));
            Session::establecerSemillasUsadas(2);
            Session::agregarMensaje("Turno ".Session::obtenerTurno().": ".$this->nombre." usa la segunda Semilla del Ermitaño (Vida: $vidaAntes → ".$this->vida.", KI: $kiAntes → ".$this->ki.")");
        }
        
        Session::incrementarTurno();
    }

    /**
     * Obtiene el nivel SSJ actual
     *
     * @return int Nivel de Super Saiyan actual
     */
    public function getNivelSSJ() {
        return $this->nivel_ssj;
    }

    /**
     * Obtiene las habilidades disponibles según el nivel SSJ
     *
     * @return array Habilidades disponibles
     */
    public function getHabilidadesDisponibles() {
        return array_filter($this->habilidades, function($habilidad) {
            return $this->nivel_ssj >= $habilidad['requiere_ssj'];
        }, ARRAY_FILTER_USE_BOTH);
    }
    
    /**
     * Verifica si el guerrero puede usar una semilla del ermitaño
     *
     * @return bool True si puede usar una semilla
     */
    public function puedeUsarSemilla() {
        return $this->vida <= ($this->vida_maxima * 0.2) && 
               (Session::obtenerSemillasUsadas() < 2);
    }
    
    /**
     * Obtiene la descripción de la semilla disponible
     *
     * @return string Descripción de la semilla
     */
    public function getDescripcionSemilla() {
        if (!Session::obtenerSemillasUsadas() || Session::obtenerSemillasUsadas() == 0) {
            return "Semilla del Ermitaño - Restaura a 180 de Vida y KI al máximo";
        } else {
            return "Semilla del Ermitaño - Restaura 100 de Vida y +50 de KI";
        }
    }
}