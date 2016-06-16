<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\MenuBundle\Model;

use Knp\Menu\MenuItem;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Routing\Router;

/**
 * Description of Menu
 * 
 * @UniqueEntity("name")
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Menu extends MenuItem implements MenuInterface
{

    /**
     * id
     */
    protected $id;

    /**
     * name
     * 
     * @Assert\NotBlank()
     */
    protected $name;
    protected $route;
    protected $link;

    /**
     * attributes,linkAttributes,childrenAttributes explain
     * code
     *  <ul>
     *      <li {$attributes}>
     *          <a href="/" {$linkAttributes}>Home</a>
     *          <ul ${childrenAttributes}>
     *              <li {$child::attributes}>
     *                  <a href="#">Next</a>
     *              </li>
     *          </ul>
     *      </li>
     *  </ul>
     */
    protected $attributes = array();
    protected $linkAttributes = array();
    protected $childrenAttributes = array();

    /**
     * 是否展开
     * @var boolean 
     */
    protected $expand = true;
    protected $weight;

    /**
     * @var Router 
     */
    protected $router;

    public function __construct($name = null)
    {
        if ($name) {
            $this->name = (string) $name;
        }
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getUri()
    {
        if ($this->route) {
            list($route, $parameters) = $this->route;
            return $this->router->generate($route, $parameters);
        }
        return parent::getUri();
    }

    public function setRoute($route, $parameters = [])
    {
        $this->route = [$route, $parameters];
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setIcon($icon)
    {
        return $this->setExtra('icon', $icon);
    }

    public function getIcon()
    {
        return $this->getExtra('icon');
    }

    public function setTemplate($template)
    {
        return $this->setExtra('template', $template);
    }

    public function getTemplate()
    {
        return $this->getExtra('template');
    }

    public function getTreeName()
    {
        $left = '　';
        $right = '└─ ';
        return str_pad($right, $this->getLevel() * strlen($left) + strlen($right), $left, STR_PAD_LEFT) . $this->getLabel();
    }

}
