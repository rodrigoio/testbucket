<?php
namespace App\Test\Core\Specification;

use App\Core\Specification\Spec;
use PHPUnit\Framework\TestCase;
use App\Core\Specification\SpecLoader;

/**
 * @group spec
 */
class SpecLoaderTest extends TestCase
{
    private $path;

    public function setUp()
    {
        parent::setUp();
        $this->path = getenv('TEST_SPEC_V1');
    }

    private function getSpecPath($filename) : string
    {
        return $this->path . DIRECTORY_SEPARATOR . $filename;
    }

    public function testLoadSpecFile()
    {
        $loader = new SpecLoader( $this->getSpecPath('001_spec_success.yaml') );
        $spec = $loader->buildSpec();
        $this->assertInstanceOf(Spec::class, $spec);
    }

    public function testLoadInexistentSpecFile()
    {
        $this->expectException(\InvalidArgumentException::class);

        $loader = new SpecLoader( $this->getSpecPath('nonono_spec.yaml') );
        $loader->buildSpec();
    }

    public function testInvalidSpecField()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Field [spec] not found');

        $loader = new SpecLoader( $this->getSpecPath('002_spec_error_spec.yaml') );
        $spec = $loader->buildSpec();
    }

    public function testInvalidFields()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Field [fields] not found');

        $loader = new SpecLoader( $this->getSpecPath('003_spec_error_fields.yaml') );
        $spec = $loader->buildSpec();
    }

    public function testInvalidFieldName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid field name');

        $loader = new SpecLoader( $this->getSpecPath('004_spec_error_field_name.yaml') );
        $spec = $loader->buildSpec();
    }

    public function testInvalidFieldDomain()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type');

        $loader = new SpecLoader( $this->getSpecPath('005_spec_error_field_domain.yaml') );
        $spec = $loader->buildSpec();
    }

    public function testInvalidDomainType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type');

        $loader = new SpecLoader( $this->getSpecPath('006_spec_error_domain_type.yaml') );
        $spec = $loader->buildSpec();
    }

    public function testInvalidDomainArgs()
    {
        $loader = new SpecLoader( $this->getSpecPath('007_spec_error_domain_args.yaml') );
        $spec = $loader->buildSpec();

        $fieldA = $spec->getFields()->get(0);
        $this->assertEquals(0, $fieldA->getDomain()->countParameters());

        $fieldB = $spec->getFields()->get(1);
        $this->assertEquals(2, $fieldB->getDomain()->countParameters());
    }
}
