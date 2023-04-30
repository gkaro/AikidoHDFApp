<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class EdcSeason extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}