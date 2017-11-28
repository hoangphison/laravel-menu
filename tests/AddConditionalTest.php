<?php

namespace Spatie\Menu\Laravel\Test;

use Spatie\Menu\Laravel\Menu;

class AddConditionalTest extends TestCase
{
    /** @test */
    public function it_adds_a_url_if_the_condition_is_true()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->urlIf(true, '/', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_a_url_if_the_condition_isnt_true()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->urlIf(false, '/', 'Home')
        );
    }

    /** @test */
    public function it_adds_an_action_if_the_condition_is_true()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->actionIf(true, DummyController::class.'@home', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_an_action_if_the_condition_isnt_true()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->actionIf(false, DummyController::class.'@home', 'Home')
        );
    }

    /** @test */
    public function it_adds_a_route_if_the_condition_is_true()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->routeIf(true, 'home', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_a_route_if_the_condition_isnt_true()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->routeIf(false, 'home', 'Home')
        );
    }
}
