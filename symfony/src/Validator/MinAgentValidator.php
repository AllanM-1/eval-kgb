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

        // Check the country and the nationality of the contact
        foreach ($value as $user) {
            if ($user->getType() == 'contact' && $user->getNationality() != $this->context->getRoot()->getData()->getCountry()) {
                $this->context->buildViolation($constraint->messageNationality)
                    ->setParameter('{{ value }}', $user->getNom().' '.$user->getPrenom())
                    ->addViolation();
            }
        }

        // Check the not same nationality of target/agent
        $targetNatio = [];
        $agentNatio = [];
        foreach ($value as $user) {

            if($user->getType() == 'target') {
                $targetNatio[] = $user->getNationality();
            }
            if($user->getType() == 'agent') {
                $agentNatio[] = $user->getNationality();
            }

        }

        if(count(array_intersect($targetNatio, $agentNatio))) {
            $this->context->buildViolation($constraint->messageTargetAgent)
                ->addViolation();
        }

        // Return if we found the first agent
        foreach ($value as $user) {
            $missionSpec = [];
            foreach ($user->getInSpeciality()->getValues() as $spec) {
                $missionSpec[] = $spec->getIdSpec();
            }

            if(!is_null($this->context->getRoot()->getData()->getSpec())) {
                if($user->getType() == 'agent' && in_array($this->context->getRoot()->getData()->getSpec()->getIdSpec(), $missionSpec)) {
                    return;
                }
            }
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
