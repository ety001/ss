<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Model\BuyService;
use App\Model\User;

class BuyServiceModelTest extends TestCase
{
    public function testChkServiceLimit() {
        $buy_service = new BuyService;
        $service_num     = $buy_service->where(['status'=>1])->count();
        if($service_num > env('SERVICE_LIMIT')) {
            $this->assertFalse($buy_service->chk_service_limit());
        } else {
            $this->assertTrue($buy_service->chk_service_limit());
        }
    }

    public function testChkService() {
        $user = factory(User::class)->make();
        $buy_service = new BuyService;
        $this->assertEquals(0, $buy_service->chk_service($user));
    }
}
