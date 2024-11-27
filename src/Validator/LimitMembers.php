<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class LimitMembers extends Constraint
{
    public string __construct(
        public int $min = 2, 
        public int $max = 5, 
        public array $equipe = [],
        public string $message = 'The value "{{ value }}" is not valid.',
        ?array $groups = null,
        mixed $payload = null)
        {
            parent::construct(null, $groups, $payload);
        }
    
    // Objectif: On veut qu'il agit sur les members qui porte la carasctéristique héros
    //Il faut qu'on puisse compter le nombre d'héros dans l'équipe
    //il faut qu'on met les héros (l'objet héros) dans un tableau 
    //Ce tableau sera l'équipe, qui contient le leader et les membres
    //Et dans cette methode il récupère un tableau (correspond à une équipe, il doit y avoir un leader) et ne mettra que les membres à l'intérieur

    public nbMembres = [];

    public int $minMember = 2;  
    public int $maxMember = 5;
}
