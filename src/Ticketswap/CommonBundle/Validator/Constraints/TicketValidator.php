<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 14/08/16
 * Time: 11:53
 */

namespace Ticketswap\CommonBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketValidator extends ConstraintValidator
{
    public function validate($tickets, Constraint $constraint)
    {
        if (!isset($tickets->tickets) || !is_array($tickets->tickets)) {
            $this->context->addViolation($constraint->message);
            return;
        }
        foreach ($tickets as $barcodes) {
            foreach ($barcodes as $barcode) {
                //TODO define which validation should be implemented here
                if (strpos($barcode, 'EAN-') === false) {
                    $this->context->addViolation($constraint->message);
                    return;
                }
            }
        }
    }
}