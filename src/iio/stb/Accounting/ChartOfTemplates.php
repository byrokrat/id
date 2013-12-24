<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Accounting;

use iio\stb\Exception\InvalidTemplateException;
use iio\stb\Exception\InvalidStructureException;

/**
 * Manage a collection of templates
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ChartOfTemplates
{
    /**
     * @var array List of loaded templates
     */
    private $templates = array();

    /**
     * Add template
     *
     * If multiple templates with the same id are added the former is
     * overwritten
     *
     * @param  Template $template
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
     * @param  string $id
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
     * @param  string $id
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
     * @param  string                   $id
     * @return Template
     * @throws InvalidTemplateException If template does not exist
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
