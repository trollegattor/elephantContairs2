<?php

namespace Tests\Unit;

use App\DTO\DataTransferObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;

class DTOTest extends TestCase
{
    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testSuccessfulCreate()
    {
        $DTO=new DataTransferObject('test1','test2',2);
        $configData=['JSON'=>storage_path('app/carrier-json.json'),
            'XML'=>storage_path('app/carrier-xml.xml')];
        $this->assertEquals($configData,$DTO->getCarriers());
        $this->assertEquals('test1',$DTO->origin);
        $this->assertEquals('test2',$DTO->destination);
        $this->assertEquals(2,$DTO->amount);
        $this->assertEquals('test1',$DTO->getOrigin());
        $this->assertEquals('test2',$DTO->getDestination());
        $this->assertEquals(2,$DTO->getAmount());
    }
}
