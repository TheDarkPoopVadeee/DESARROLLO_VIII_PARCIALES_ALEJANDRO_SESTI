<?php
interface obtenerDetallesEspecificos {
    public function obtenerDetallesEspecificos(): string;
}

abstract class Entrada implements obtenerDetallesEspecificos {
    public $id;
    public $fecha_creacion;
    public $tipo;
    public $titulo;
    public $descripcion;

    public function __construct($datos = []) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Definimos el método abstracto para forzar su implementación en clases hijas
    abstract public function obtenerDetallesEspecificos(): string;
}

class EntradaUnaColumna extends Entrada {
    public function obtenerDetallesEspecificos(): string {
        return $this->titulo;
    }
}

class EntradaDosColumnas extends Entrada {
    public $titulo2;
    public $descripcion2;

    public function obtenerDetallesEspecificos(): string {
        return "{$this->titulo}, {$this->titulo2}";
    }
}

class EntradaTresColumnas extends Entrada {
    public $titulo2;
    public $descripcion2;
    public $titulo3;
    public $descripcion3;

    public function obtenerDetallesEspecificos(): string {
        return "{$this->titulo}, {$this->titulo2}, {$this->titulo3}";
    }
}

class GestorBlog {
    private $entradas = [];

    public function cargarEntradas() {
        if (file_exists('blog.json')) {
            $json = file_get_contents('blog.json');
            $data = json_decode($json, true);
            foreach ($data as $entradaData) {
                $this->entradas[] = new Entrada($entradaData); // Especifica la clase correspondiente
            }
        }
    }

    public function guardarEntradas() {
        $data = array_map(function($entrada) {
            return get_object_vars($entrada);
        }, $this->entradas);
        file_put_contents('blog.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    public function obtenerEntradas() {
        return $this->entradas;
    }

    public function agregarEntrada(Entrada $entrada) {
        $entrada->id = end($this->entradas)->id + 1;
        $this->entradas[] = $entrada;
    }

    public function editarEntrada($id, $nuevosDatos) {
        foreach ($this->entradas as &$entrada) {
            if ($entrada->id == $id) {
                foreach ($nuevosDatos as $key => $value) {
                    if (property_exists($entrada, $key)) {
                        $entrada->$key = $value;
                    }
                }
            }
        }
    }

    public function eliminarEntrada($id) {
        $this->entradas = array_filter($this->entradas, function($entrada) use ($id) {
            return $entrada->id != $id;
        });
    }

    public function obtenerEntrada($id) {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id == $id) {
                return $entrada;
            }
        }
        return null;
    }

    public function moverEntrada($id, $direccion) {
        // Implementación de la lógica de mover la entrada en el array
    }

    public function guardarInfo($entrada) {
        $jsonData = json_encode($entrada);
        file_put_contents('blog.json', $jsonData, FILE_APPEND);
    }
}
?>