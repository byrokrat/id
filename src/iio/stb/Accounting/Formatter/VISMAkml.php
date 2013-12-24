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

namespace iio\stb\Accounting\Formatter;

use iio\stb\Accounting\Template;

/**
 * Export and import accounting templates in VISMA kml format
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class VISMAkml
{
    /**
     * End of line char
     */
    const EOL = "\r\n";

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
     * Get loaded tempaltes. 
     *
     * @return array Template ids as keys
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Export templates in VISMA kml format
     *
     * @return string In ISO-8859-1 charset
     */
    public function export()
    {
        $kml = "";
        $templateIndex = 0;
        foreach ($this->templates as $template) {
            $kml .= "[KontMall{$templateIndex}]" . self::EOL;
            $kml .= "id={$template->getId()}" . self::EOL;
            $kml .= "namn={$template->getName()}" . self::EOL;
            $kml .= "text={$template->getText()}" . self::EOL;

            foreach ($template->getTransactions() as $index => $arTransData) {
                list($number, $amount) = $arTransData;
                $lineNr = $index + 1;
                $kml .= "Rad{$index}_radnr={$lineNr}" . self::EOL;
                $kml .= "Rad{$index}_konto={$number}" . self::EOL;
                $kml .= "Rad{$index}_belopp={$amount}" . self::EOL;
            }

            $templateIndex++;
        }

        return iconv("UTF-8", "ISO-8859-1", $kml);
    }

    /**
     * Import templates from VISMA kml format
     *
     * @param  string $kml Must be ISO-8859-1 charset
     * @return void
     */
    public function import($kml)
    {
        $kml = iconv("ISO-8859-1", "UTF-8", $kml);
        $data = @parse_ini_string($kml, true, INI_SCANNER_RAW);

        foreach ($data as $values) {
            $id = isset($values['id']) ? $values['id'] : '';
            $name = isset($values['namn']) ? $values['namn'] : '';
            $text = isset($values['text']) ? $values['text'] : '';
            $template = new Template();
            $template->setId($id);
            $template->setName($name);
            $template->setText($text);

            $index = 0;
            while (true) {
                // Break when there are no more transactions
                if (!isset($values["Rad{$index}_konto"]) || !isset($values["Rad{$index}_belopp"])) {
                    break;
                }
                // Add this transaction
                $template->addTransaction(
                    $values["Rad{$index}_konto"],
                    $values["Rad{$index}_belopp"]
                );
                $index++;
            }
            $this->addTemplate($template);
        }
    }
}
