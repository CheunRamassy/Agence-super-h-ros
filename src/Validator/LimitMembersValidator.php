<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintValidator;

class LimitMembersValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var LimitMembers $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        // if (Length($constraint->equipe) > constraint->max && length(constraint->equipe) < constraint->min){
        //     $this->context->buildViolation($constraint->message)
        //     ->setParameter('{{ value }}', $value)
        //     ->addViolation();
        // }


    }
}
