<?php

namespace App\Util\Attribute\Transformer;

#[\Attribute]
class EntityTransformer
{
    public function __construct(
        public string $targetClass = '',
        public string $keyProperty = 'id',
    ) {
    }
}