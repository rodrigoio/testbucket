Test Bucket
===========
TestBucket is a tool that aims to assist the testing process by generating functional test cases.

About
---------------
This tool aims to generate test cases from the definition of a specification in YAML notation.
This specification aims to determine input domains, correlation between fields in a form.
As well as business rules and contexts.

Once we have a specification in a concrete and not subjective way, we can apply several known techniques of
software tests to actually generate test cases. The scope of this project is limited, for now, to generate integrated
tests not having a direct relationship with the application code, but with the specification of the requirements.

If at any time you have realized how complex it is to deal with test cases, consider contributing to this project.

Install:
--------
```shell script
docker-compose up -d
```

Configuration:
--------------
| Variable          | Description |
|-------------------|-------------|
| `TESTBUCKET_DIR`  | Define where the sqlite database (or bucket) will be created |


Usage on PHPUnit tests:
----------------------
```php
<?php

use PHPUnit\Framework\TestCase;

use App\Entity\Product;

use TestBucket\Core\Combiner\Builder;
use TestBucket\Core\Combiner\TestCaseBucket;
use TestBucket\Core\Combiner\TestCaseReceiverInterface;

class FooTestCase extends TestCase implements TestCaseReceiverInterface
{
    private $bucket;
    private $products;

    public function setUp()
    {
        parent::setUp();

        $spec = new Builder('product');
        $result = $spec
            ->setGroup('product')
            ->property("name"   , ['product'])
            ->property("qty"    , [23])
            ->property("price"  , [0.0, 500.34])
            ->property("status" , [1, 2, 3])
            ->property("type"   , [1, 2])
            ->build();

        $this->bucket = new TestCaseBucket('products');
        $this->bucket->setReceiver($this);
        $this->bucket->persist($result);

        $this->products = [];
    }

    // (...)
    // Use populated ( $this->products ) in tests
    // (...)

    public function receiveTestCase($testCaseKeys, $testCaseData, $label)
    {
        $data = [];
        foreach ($testCaseData as $item) {
            $data[$item['key']] = $item['value'];
        }

        $this->products[$label] = new Product($data['name'], $data['qty'], $data['price'], $data['status']);
    }
}
```

Contact:
-------
If you want to contribute to this project, see the [guidelines][0]

[0]: https://github.com/rodrigoio/testbucket/blob/master/CONTRIBUTING.md
