<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelperTest extends TestCase
{
    /**
     * Test get_weidian_access_token()
     *
     * @return void
     */
    public function testGetWeidianAccessToken()
    {
        $access_token = get_weidian_access_token();
        $this->assertTrue(is_string($access_token));
    }

    /**
     * Test get_weidian_order_info()
     *
     * @return void
     */
    public function testGetWeidianOrderInfo()
    {
        $order_info = get_weidian_order_info('774695274341076');
        $this->assertEquals(0, $order_info['status']['status_code']);
    }
}
