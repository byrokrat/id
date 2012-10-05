<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\Accounting
 */

namespace itbz\stb\Accounting;

use itbz\stb\Exception\InvalidTemplateException;
use itbz\stb\Exception\InvalidStructureException;

/**
 * Manage a collection of templates
 *
 * @package stb\Accounting
 */
class ChartOfTemplates
{
    /**
     * List of loaded templates
     *
     * @var array
     */
    private $templates = array();

    /**
     * Add template
     *
     * If multiple templates with the same id are added the former is
     * overwritten
     *
     * @param Template $template
     *
     * @return void
     */
    public function addTemplate(Template $template)
    {
        $id = $template->getId();
        $this->templates[$id] = $template;
    }

    /**
     * Drop template using id
     *
     * @param string $id
     *
     * @return void
     */
    public function dropTemplate($id)
    {
        assert('is_string($id)');
        unset($this->templates[$id]);
    }

    /**
     * Check if template exists
     *
     * @param string $id
     *
     * @return bool
     */
    public function exists($id)
    {
        assert('is_string($id)');
        return isset($this->templates[$id]);
    }

    /**
     * Get a template clone using id
     *
     * @param string $id
     *
     * @return Template
     *
     * @throws InvalidTemplateException if template does not exist
     */
    public function getTemplate($id)
    {
        assert('is_string($id)');
        if (!$this->exists($id)) {
            $msg = "Unable to fetch template '$id', does not exist";
            throw new InvalidTemplateException($msg);
        }
        return clone $this->templates[$id];
    }

    /**
     * Get loaded tempaltes. 
     *
     * @return array Template ids as keys
     */
    public function getTemplates()
    {
        return $this->templates;
    }
}
