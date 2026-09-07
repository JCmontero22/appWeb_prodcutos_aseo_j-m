<?php

class Validador
{
    private static $errores = [];

    public static function reset()
    {
        self::$errores = [];
    }

    public static function validarNumero($valor, $nombre, $minimo = null, $maximo = null)
    {
        if (!is_numeric($valor)) {
            self::$errores[] = "$nombre debe ser un número válido";
            return false;
        }

        $numero = (float)$valor;

        if ($minimo !== null && $numero < $minimo) {
            self::$errores[] = "$nombre debe ser mayor o igual a $minimo";
            return false;
        }

        if ($maximo !== null && $numero > $maximo) {
            self::$errores[] = "$nombre debe ser menor o igual a $maximo";
            return false;
        }

        return true;
    }

    public static function validarEntero($valor, $nombre, $minimo = null, $maximo = null)
    {
        if (!is_numeric($valor) || intval($valor) != $valor) {
            self::$errores[] = "$nombre debe ser un número entero";
            return false;
        }

        $entero = (int)$valor;

        if ($minimo !== null && $entero < $minimo) {
            self::$errores[] = "$nombre debe ser mayor o igual a $minimo";
            return false;
        }

        if ($maximo !== null && $entero > $maximo) {
            self::$errores[] = "$nombre debe ser menor o igual a $maximo";
            return false;
        }

        return true;
    }

    public static function validarCantidad($cantidad, $nombre = "Cantidad")
    {
        if (!self::validarEntero($cantidad, $nombre, 1)) {
            return false;
        }
        return true;
    }

    public static function validarPrecio($precio, $nombre = "Precio")
    {
        if (!self::validarNumero($precio, $nombre, 0)) {
            return false;
        }
        return true;
    }

    public static function validarID($id, $nombre = "ID")
    {
        if (!self::validarEntero($id, $nombre, 1)) {
            return false;
        }
        return true;
    }

    public static function validarEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$errores[] = "Email inválido";
            return false;
        }
        return true;
    }

    public static function validarLongitud($valor, $nombre, $minimo, $maximo = null)
    {
        $longitud = strlen($valor);

        if ($longitud < $minimo) {
            self::$errores[] = "$nombre debe tener al menos $minimo caracteres";
            return false;
        }

        if ($maximo !== null && $longitud > $maximo) {
            self::$errores[] = "$nombre debe tener máximo $maximo caracteres";
            return false;
        }

        return true;
    }

    public static function validarRequerido($valor, $nombre)
    {
        if (empty($valor)) {
            self::$errores[] = "$nombre es requerido";
            return false;
        }
        return true;
    }

    public static function sanitizar($valor)
    {
        if (is_array($valor)) {
            return array_map([self::class, 'sanitizar'], $valor);
        }
        return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
    }

    public static function obtenerErrores()
    {
        return self::$errores;
    }

    public static function hayErrores()
    {
        return !empty(self::$errores);
    }

    public static function primerError()
    {
        return self::$errores[0] ?? null;
    }
}
?>
