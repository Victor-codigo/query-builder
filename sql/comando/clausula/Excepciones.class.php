<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;

use GT\Libs\Sistema\BD\BDException;
//******************************************************************************


/**
 * Excepción de un claúsula
 */
class ClausulaException extends BDException {}
//******************************************************************************


/**
 * No Existe este tipo de JOIN para la base de datos
 */
class JoinNoExisteException extends ClausulaException {}
//******************************************************************************