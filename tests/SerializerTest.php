<?php

declare(strict_types=1);

namespace Tests;

use App\DataTransferObject\Dummy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerTest extends TestCase
{
    public function testWithNameConverter(): void
    {
        $expectedDummy = new Dummy();
        $expectedDummy->fooString = '3';

        $serializer = new Serializer(
            [
                new PropertyNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    propertyTypeExtractor: new PropertyInfoExtractor(
                        listExtractors: [new ReflectionExtractor()],
                        typeExtractors: [new ReflectionExtractor()],
                        accessExtractors: [new ReflectionExtractor()],
                        initializableExtractors: [new ReflectionExtractor()],
                    ),
                ),
            ],
            [
                new JsonEncoder(),
            ],
        );

        $dummy = $serializer->deserialize('{"foo_string":"3"}', Dummy::class, 'json');

        $this->assertEquals($expectedDummy, $dummy);
    }

    public function testWithoutNameConverter(): void
    {
        $expectedDummy = new Dummy();

        $serializer = new Serializer(
            [
                new PropertyNormalizer(
                    propertyTypeExtractor: new PropertyInfoExtractor(
                        listExtractors: [new ReflectionExtractor()],
                        typeExtractors: [new ReflectionExtractor()],
                        accessExtractors: [new ReflectionExtractor()],
                        initializableExtractors: [new ReflectionExtractor()],
                    ),
                ),
            ],
            [
                new JsonEncoder(),
            ],
        );

        $dummy = $serializer->deserialize('{"foo_string":"3"}', Dummy::class, 'json');

        $this->assertEquals($expectedDummy, $dummy);
    }

    public function testThatInvalidTypeCauseException(): void
    {
        $this->expectException(NotNormalizableValueException::class);
        $this->expectExceptionMessage('The type of the "fooString" attribute for class "'.Dummy::class.'" must be one of "string" ("int" given).');

        $serializer = new Serializer(
            [
                new PropertyNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    propertyTypeExtractor: new PropertyInfoExtractor(
                        listExtractors: [new ReflectionExtractor()],
                        typeExtractors: [new ReflectionExtractor()],
                        accessExtractors: [new ReflectionExtractor()],
                        initializableExtractors: [new ReflectionExtractor()],
                    ),
                ),
            ],
            [
                new JsonEncoder(),
            ],
        );

        $serializer->deserialize('{"foo_string":3}', Dummy::class, 'json');
    }

    public function testThatInvalidTypeWillBeConvertedBecauseOfContextOnProperty(): void
    {
        $expectedDummy = new Dummy();
        $expectedDummy->fooString = '3';

        $serializer = new Serializer(
            [
                new PropertyNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    propertyTypeExtractor: new PropertyInfoExtractor(
                        listExtractors: [new ReflectionExtractor()],
                        typeExtractors: [new ReflectionExtractor()],
                        accessExtractors: [new ReflectionExtractor()],
                        initializableExtractors: [new ReflectionExtractor()],
                    ),
                    classMetadataFactory: new ClassMetadataFactory(
                        new AnnotationLoader()
                    )
                ),
            ],
            [
                new JsonEncoder(),
            ],
        );

        $dummy = $serializer->deserialize('{"foo_string":3}', Dummy::class, 'json');

        $this->assertEquals($expectedDummy, $dummy);
    }
}
