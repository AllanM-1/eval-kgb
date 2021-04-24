<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SameCountryValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\SameCountry */

        foreach ($value as $hideout) {
            if($hideout->getCountry() !== $this->context->getRoot()->getData()->getCountry()) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $hideout->getAddress().' '.$hideout->getPostcode().' '.$hideout->getCity())
                    ->addViolation();
            }
        }
    }
}
