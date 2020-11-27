<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Core\Combiner\AggregatorList;
use TestBucket\Core\Combiner\SpecificationBuilder;
use PHPUnit\Framework\TestCase;
use TestBucket\Core\Combiner\Tuple;

/**
 * @group combiner_spec_builder
 */
class SpecificationBuilderTest extends TestCase
{
    public function testBuild()
    {
        $builder = new SpecificationBuilder('person');

        $result =
            $builder
                ->property('age', [20, 45, 60])
                ->build();

        $this->assertInstanceOf(AggregatorList::class, $result);
        $combinedData = json_decode(json_encode($result), true);

        // aggregator 1
        $this->assertArrayHasKey('person:age:(MjA=)', $combinedData[0]);
        $this->assertArrayHasKey('person:age:(NDU=)', $combinedData[0]);
        $this->assertArrayHasKey('person:age:(NjA=)', $combinedData[0]);


        // Tuples
        $tpAge01 = new Tuple('user', 'age', 20);
        $tpAge02 = new Tuple('user', 'age', 45);
        $tpAge03 = new Tuple('user', 'age', 60);

        $tpStatus01 = new Tuple('user', 'status', 0);
        $tpStatus02 = new Tuple('user', 'status', 1);
        $tpStatus03 = new Tuple('user', 'status', 2);
        $tpStatus04 = new Tuple('user', 'status', 3);

        $tpEmail01 = new Tuple('user', 'email', 'email@email.com');
        $tpEmail02 = new Tuple('user', 'email', null);

        $builder = new SpecificationBuilder('user');

        $result =
            $builder
                ->property('age', [20, 45, 60])
                ->property('status', [0, 1, 2, 3])
                ->property('email', ['email@email.com', null])
                ->build();

        $combinedData = json_decode(json_encode($result), true);

        $sumary = [];
        foreach ($combinedData as $key=>$value) {
            $sumary[] = implode(',', array_keys($value));
        }

        // Starting with age (20):
        //
        // (20) * (0, 1, 2, 3) * (null, email) => [(20, 0), (20, 1), (20, 2), (20, 3)]
        //
        // [(20, 0), (20, 1), (20, 2), (20, 3)] * (null, email) =>
        //
        // (20, 0, null), (20, 1, null), (20, 2, null), (20, 3, null)
        // (20, 0, email), (20, 1, email), (20, 2, email), (20, 3, email)
        //
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[0]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[1]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[2]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[3]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[4]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[5]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[6]);
        $this->assertEquals("{$tpAge01->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[7]);

        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[8]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[9]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[10]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[11]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[12]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[13]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[14]);
        $this->assertEquals("{$tpAge02->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[15]);

        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[16]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus01->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[17]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[18]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus02->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[19]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[20]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus03->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[21]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail01->getUniqueKey()}", $sumary[22]);
        $this->assertEquals("{$tpAge03->getUniqueKey()},{$tpStatus04->getUniqueKey()},{$tpEmail02->getUniqueKey()}", $sumary[23]);
    }
}