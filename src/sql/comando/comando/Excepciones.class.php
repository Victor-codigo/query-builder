<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando;
use GT\Libs\Sistema\BD\BDException;
//******************************************************************************


/**
 * Excepcion del comando
 */
class ComandoException extends BDException {}
//******************************************************************************


/**
 * Excepción al ejecutar el comando
 */
class ComandoEjecutarException extends ComandoException {}
//******************************************************************************


/**
 * Escepciones para la recuperación de los datos del comando
 */
class ComandoFetchException extends ComandoException {}
//******************************************************************************

/**
 * Para fetch columns no existe la columna
 */
class ComandoFetchColumnNoEsisteException extends ComandoFetchException {}
//******************************************************************************

/**
 * No existe la clausula principal del comando cuando se genera
 */
class ComandoGenerarClausulaPrincipalNoExisteException extends ComandoException {}
//******************************************************************************