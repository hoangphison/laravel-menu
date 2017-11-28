<?php

namespace Spatie\Menu\Laravel;

use Spatie\Menu\Item;
use Spatie\Menu\Menu as BaseMenu;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Support\Htmlable;

class Menu extends BaseMenu implements Htmlable
{
    use Macroable;

    /**
     * Set all relevant children active based on the current request's URL.
     *
     * /, /about, /contact => request to /about will set the about link active.
     *
     * /en, /en/about, /en/contact => request to /en won't set /en active if the
     *                                request root is set to /en.
     *
     * @param string $requestRoot If the link's URL is an exact match with the
     *                            request root, the link won't be set active.
     *                            This behavior is to avoid having home links
     *                            active on every request.
     *
     * @return $this
     */
    public function setActiveFromRequest($requestRoot = '/')
    {
        return $this->setActive(app('request')->url(), $requestRoot);
    }

    /**
     * @param string $path
     * @param string $text
     * @param mixed $parameters
     * @param bool|null $secure
     *
     * @return $this
     */
    public function url($path, $text, $parameters = [], $secure = null)
    {
        return $this->add(Link::toUrl($path, $text, $parameters, $secure));
    }

    /**
     * @param string $action
     * @param string $text
     * @param mixed $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function action($action, $text, $parameters = [], $absolute = true)
    {
        return $this->add(Link::toAction($action, $text, $parameters, $absolute));
    }

    /**
     * @param string $name
     * @param string $text
     * @param mixed $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function route($name, $text, $parameters = [], $absolute = true)
    {
        return $this->add(Link::toRoute($name, $text, $parameters, $absolute));
    }

    /**
     * @param string $name
     * @param array $data
     *
     * @return $this
     */
    public function view($name, array $data = [])
    {
        return $this->add(View::create($name, $data));
    }

    /**
     * @param bool $condition
     * @param string $path
     * @param string $text
     * @param array $parameters
     * @param bool|null $secure
     *
     * @return $this
     */
    public function urlIf($condition, $path, $text, array $parameters = [], $secure = null)
    {
        return $this->addIf($condition, Link::toUrl($path, $text, $parameters, $secure));
    }

    /**
     * @param bool $condition
     * @param string $action
     * @param string $text
     * @param array $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function actionIf($condition, $action, $text, array $parameters = [], $absolute = true)
    {
        return $this->addIf($condition, Link::toAction($action, $text, $parameters, $absolute));
    }

    /**
     * @param bool $condition
     * @param string $name
     * @param string $text
     * @param array $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function routeIf($condition, $name, $text, array $parameters = [], $absolute = true)
    {
        return $this->addIf($condition, Link::toRoute($name, $text, $parameters, $absolute));
    }

    /**
     * @param $condition
     * @param string $name
     * @param array $data
     *
     * @return $this
     */
    public function viewIf($condition, $name, array $data = null)
    {
        return $this->addIf($condition, View::create($name, $data));
    }

    /**
     * @param string|array $authorization
     * @param \Spatie\Menu\Item $item
     *
     * @return $this
     */
    public function addIfCan($authorization, Item $item)
    {
        $ablityArguments = is_array($authorization) ? $authorization : [$authorization];
        $ability = array_shift($ablityArguments);

        return $this->addIf(app(Gate::class)->allows($ability, $ablityArguments), $item);
    }

    /**
     * @param string|array $authorization
     * @param string $url
     * @param string $text
     *
     * @return $this
     */
    public function linkIfCan($authorization, $url, $text)
    {
        return $this->addIfCan($authorization, Link::to($url, $text));
    }

    /**
     * @param string|array $authorization
     * @param string $html
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public function htmlIfCan($authorization, $html)
    {
        return $this->addIfCan($authorization, Html::raw($html));
    }

    /**
     * @param string|array $authorization
     * @param callable|\Spatie\Menu\Menu|\Spatie\Menu\Item $header
     * @param callable|\Spatie\Menu\Menu|null $menu
     *
     * @return $this
     */
    public function submenuIfCan($authorization, $header, $menu = null)
    {
        list($authorization, $header, $menu) = $this->parseSubmenuIfCanArgs(...func_get_args());

        $menu = $this->createSubmenuMenu($menu);
        $header = $this->createSubmenuHeader($header);

        return $this->addIfCan($authorization, $menu->prependIf($header, $header));
    }

    protected function parseSubmenuIfCanArgs($authorization, ...$args)
    {
        return array_merge([$authorization], $this->parseSubmenuArgs($args));
    }

    /**
     * @param string|array $authorization
     * @param string $path
     * @param string $text
     * @param array $parameters
     * @param bool|null $secure
     *
     * @return $this
     */
    public function urlIfCan($authorization, $path, $text, array $parameters = [], $secure = null)
    {
        return $this->addIfCan($authorization, Link::toUrl($path, $text, $parameters, $secure));
    }

    /**
     * @param string|array $authorization
     * @param string $action
     * @param string $text
     * @param array $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function actionIfCan($authorization, $action, $text, array $parameters = [], $absolute = true)
    {
        return $this->addIfCan($authorization, Link::toAction($action, $text, $parameters, $absolute));
    }

    /**
     * @param string|array $authorization
     * @param string $name
     * @param string $text
     * @param array $parameters
     * @param bool $absolute
     *
     * @return $this
     */
    public function routeIfCan($authorization, $name, $text, array $parameters = [], $absolute = true)
    {
        return $this->addIfCan($authorization, Link::toRoute($name, $text, $parameters, $absolute));
    }

    /**
     * @param $authorization
     * @param string $name
     * @param array $data
     *
     * @return $this
     * @internal param $condition
     */
    public function viewIfCan($authorization, $name, array $data = null)
    {
        return $this->addIfCan($authorization, View::create($name, $data));
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }
}
