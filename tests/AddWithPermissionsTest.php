<?php

namespace Spatie\Menu\Laravel\Test;

use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;
use Illuminate\Auth\GenericUser;

class AddWithPermissionsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        auth()->login(new GenericUser(['id' => 1]));
    }

    /** @test */
    public function it_adds_an_item_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="/">Home</a></li></ul>',
            Menu::newMenu()->addIfCan('computerSaysYes', Link::to('/', 'Home'))
        );
    }

    /** @test */
    public function it_doesnt_add_an_item_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->addIfCan('computerSaysNo', Link::to('/', 'Home'))
        );
    }

    /** @test */
    public function it_parses_argument_if_an_ability_is_provided_as_an_array()
    {
        $this->assertRenders(
            '<ul><li><a href="/">Home</a></li></ul>',
            Menu::newMenu()->addIfCan(['computerSaysMaybe', true], Link::to('/', 'Home'))
        );

        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->addIfCan(['computerSaysMaybe', false], Link::to('/', 'Home'))
        );
    }

    /** @test */
    public function it_adds_a_link_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="/">Home</a></li></ul>',
            Menu::newMenu()->linkIfCan('computerSaysYes', '/', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_a_link_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->linkIfCan('computerSaysNo', '/', 'Home')
        );
    }

    /** @test */
    public function it_adds_html_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="/">Home</a></li></ul>',
            Menu::newMenu()->htmlIfCan('computerSaysYes', '<a href="/">Home</a>')
        );
    }

    /** @test */
    public function it_doesnt_add_html_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->htmlIfCan('computerSaysNo', '<a href="/">Home</a>')
        );
    }

    /** @test */
    public function it_adds_a_url_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->urlIfCan('computerSaysYes', '/', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_a_url_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->urlIfCan('computerSaysNo', '/', 'Home')
        );
    }

    /** @test */
    public function it_adds_an_action_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->actionIfCan('computerSaysYes', DummyController::class.'@home', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_an_action_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->actionIfCan('computerSaysNo', DummyController::class.'@home', 'Home')
        );
    }

    /** @test */
    public function it_adds_a_route_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="http://localhost">Home</a></li></ul>',
            Menu::newMenu()->routeIfCan('computerSaysYes', 'home', 'Home')
        );
    }

    /** @test */
    public function it_doesnt_add_a_route_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->routeIfCan('computerSaysNo', 'home', 'Home')
        );
    }

    /** @test */
    public function it_adds_a_submenu_if_the_user_has_a_certain_ability()
    {
        $this->assertRenders(
            '<ul><li><a href="home">Home</a><ul><li><a href="sub">Sub</a></li></ul></li></ul>',
            Menu::newMenu()->submenuIfCan('computerSaysYes', Link::to('home', 'Home'), Menu::newMenu()->link('sub', 'Sub'))
        );
    }

    /** @test */
    public function it_doesnt_add_a_submenu_if_the_user_doesnt_have_a_certain_ability()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::newMenu()->submenuIfCan('computerSaysNo', Link::to('home', 'Home'), Menu::newMenu()->link('sub', 'Sub'))
        );
    }
}
