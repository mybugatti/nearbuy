<?php
namespace NearBuy\DataBundle\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class ReductionType extends AbstractEnumType
{
    const RELATIVE = 'R';
    const ABSOLUTE = 'A';
    const OTHER = 'O';

    protected static $choices = [
        self::RELATIVE => 'Réduction relative',
        self::ABSOLUTE => 'Réduction absolute',
        self::OTHER => 'Autre type réduction'
    ];
}