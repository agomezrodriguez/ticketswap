<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 14/08/16
 * Time: 11:52
 */


namespace Ticketswap\CommonBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Ticket extends Constraint
{
    public $message = 'Invalid tickets format provided. Expected json format with an array of barcodes for each ticket';
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}