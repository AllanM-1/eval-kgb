<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class MinAgent extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'A mission need at least one agent with the same speciality.';
    public $messageNationality = 'The contact "{{ value }}" isn\'t in the same country than the misson.';
}
