<?php
namespace App\Managers;

use Illuminate\Support\Manager;
use App\Services\JsonService\JsonService;

class TypeManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'jsonservice';
    }
    public function createJsonServiceDriver()
    {
        return new JsonService();
    }
    public function createBicycleDriver()
    {
        return new Bicycle();
    }

}
