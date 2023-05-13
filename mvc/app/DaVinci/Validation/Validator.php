<?php
namespace DaVinci\Validation;

use DaVinci\Models\User;

use Exception;

class Validator
{
    /** @var array Los campos a validar. */
    protected $campos;

    /** @var array Las reglas a aplicar. */
    protected $reglas;

    /** @var array Los errores que ocurrieron. */
    protected $errores = [];

    /**
     * Validator constructor.
     * @param array $campos
     * @param array $reglas
     */
    public function __construct($campos, $reglas)
    {
        $this->campos = $campos;
        $this->reglas = $reglas;

        $this->validar();
    }

    /**
     * Realiza la validación.
     */
    protected function validar()
    {
        
        foreach($this->reglas as $nombreCampo => $reglasCampo) {

            $this->aplicarListaReglas($nombreCampo, $reglasCampo);
        }
    }

    /**
     * Aplica la $listaReglas sobre el valor del $campo.
     *
     * @param string $campo
     * @param array $listaReglas
     * @throws Exception
     */
    protected function aplicarListaReglas($campo, $listaReglas)
    {

        foreach($listaReglas as $regla) {

            $this->aplicarRegla($campo, $regla);
        }
    }

    /**
     * Aplica la $regla de validación al $campo.
     *
     * @param string $campo
     * @param string $regla
     * @throws Exception
     */
    protected function aplicarRegla($campo, $regla)
    {

        if(strpos($regla, ':') !== false) {

            [$nombreRegla, $parametroRegla] = explode(':', $regla);

            $nombreMetodo = '_' . $nombreRegla;

            if(!method_exists($this, $nombreMetodo)) {
                throw new Exception('No existe una validación llamada ' . $nombreRegla . '.');
            }
            
            $this->{$nombreMetodo}($campo, $parametroRegla);
        } else {
            $nombreMetodo = '_' . $regla;

            if(!method_exists($this, $nombreMetodo)) {
                throw new Exception('No existe una validación llamada ' . $regla . '.');
            }

            $this->{$nombreMetodo}($campo);
        }

    }

    /**
     * Agrega el $mensaje de error para el $campo.
     *
     * @param string $campo
     * @param string $mensaje
     */
    protected function registrarError($campo, $mensaje)
    {
        if(!isset($this->errores[$campo])) {
            $this->errores[$campo] = [];
        }
        $this->errores[$campo][] = $mensaje;
    }

    /**
     * Retorna un booleano dependiendo de la validacion
     *
     * @return bool
     */
    public function passes()
    {
        return empty($this->errores);
    }

    /**
     * Retorna los errores.
     *
     * @return array
     */
    public function getErrores()
    {
        return $this->errores;
    }

    /**
     * Esta función la uso para asignale el nombre a los campos cuando valido
     * @param  String
     * @return String
     */
    public function camposNombre($campo){
        switch($campo) {
            case 'password':
                return $input = 'contraseña';
                break;
            case 'confirm_password':
                return $input = 'confirmar contraseña';
                break;
            case 'content':
                return $input = 'contenido';
                break;
            case 'user':
                return $input = 'usuario';
                break;
            case 'email':
                return $input = 'correo electronico';
                break;
            case 'name':
                return $input = 'nombre';
                break;
            case 'surname':
                return $input = 'apellido';
                break;

            default:
                return $input = strtolower($campo);
                break;
        }
    }

    /**
     * Valida que el valor del campo no sea vacío.
     *
     * @param string $campo
     */
    protected function _required($campo)
    {
        if(empty($this->campos[$campo])) {
            $this->registrarError($campo, 'El campo ' . $this->camposNombre($campo) . ' no debe estar vacío');
        }
    }

    /**
     * Valida que el valor del campo sea un número.
     *
     * @param string $campo
     */
    protected function _numeric($campo)
    {
        if(!is_numeric($this->campos[$campo])) {
            $this->registrarError($campo, 'El campo ' . $this->camposNombre($campo) . ' debe ser un número');
        }
    }

    /**
     * Valida que el campo tenga al menos $cantidad caracteres.
     *
     * @param string $campo
     * @param int $cantidad
     */
    protected function _min($campo, $cantidad)
    {
        if(strlen($this->campos[$campo]) < $cantidad) {
            $this->registrarError($campo, 'El campo ' . $this->camposNombre($campo) . ' debe tener al menos ' . $cantidad . ' caracteres');
        }
    }

    protected function _max($campo, $cantidad)
    {
        if(strlen($this->campos[$campo]) > $cantidad) {
            $this->registrarError($campo, 'El campo ' . $this->camposNombre($campo) . ' no puede ser mayor a ' . $cantidad . ' caracteres');
        }
    }

    /**
     * Valida que el valor del campo sea un email.
     *
     * @param string $campo
     */
    protected function _email($campo)
    {
        if (!filter_var($this->campos[$campo], FILTER_VALIDATE_EMAIL)) {
            $this->registrarError($campo, 'El campo ' . $this->camposNombre($campo) . ' no tiene un formato correcto');
        }
    }

    protected function _unique($campo, $column)
    {       
        $user = new User();

        try {
            
            $user->buscarValorUnico($this->campos[$campo], $column);
           
        } catch (Exception $exception) {
            $this->registrarError($campo, $exception->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Valida que el campo tenga al menos $cantidad caracteres.
     *
     * @param string $campo
     */
    protected function _repeat($campo)
    {
        if(true) {
            $this->registrarError($campo, 'El ' . $this->camposNombre($campo) . ' ingresado ya existe en nuestros registros');
        }
    }
}
