<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Model\User;

class UserModelTest extends TestCase
{
    public function testChkMoney() {
        $user = factory(User::class)->states('money_amount_30')->make();
        $this->assertTrue($user->chk_money(30));
        $this->assertFalse($user->chk_money(40));
        $this->assertTrue($user->chk_money(20));
        $this->assertFalse($user->chk_money());
    }

    public function testChangeMoney() {
        $user = factory(User::class)->make();
        $user->change_money(20);
        $this->assertEquals(20, $user->money_amount);
        $user->change_money(-10);
        $this->assertEquals(10, $user->money_amount);
    }
}
