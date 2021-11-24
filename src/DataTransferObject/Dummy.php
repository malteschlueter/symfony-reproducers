<?php

declare(strict_types=1);

namespace App\DataTransferObject;

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

class Dummy
{
    #[Serializer\Context(context: [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
    public string $fooString;
}
