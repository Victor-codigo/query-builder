<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor;
use GT\Libs\Sistema\BD\BDException;
//******************************************************************************


/**
 * Excepcion del comando
 */
class ComandoConstructorException extends BDException {}
//******************************************************************************

/**
 * Excepcion del de la cadena de construcción del comando Update, metodo increment
 */
class ComandoConstructorUpdateIncrementValorNegativoException extends BDException {}
//******************************************************************************

/**
 * Excepcion del de la cadena de construcción del comando Update, metodo decrement
 */
class ComandoConstructorUpdateDecrementValorNegativoException extends BDException {}
//******************************************************************************