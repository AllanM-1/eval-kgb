<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinAgentValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\MinAgent */

        // Return if we found the first agent
        foreach ($value as $user) {
            $missionSpec = [];
            foreach ($user->getInSpeciality()->getValues() as $spec) {
                $missionSpec[] = $spec->getIdSpec();
            }

            if($user->getType() == 'agent' && in_array($this->context->getRoot()->getData()->getSpec()->getIdSpec(), $missionSpec)) {
                return;
            }
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
