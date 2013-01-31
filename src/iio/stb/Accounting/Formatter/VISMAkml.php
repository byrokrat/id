<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\Accounting\Formatter
 */

namespace iio\stb\Accounting\Formatter;

use iio\stb\Accounting\Template;

/**
 * Export and import accounting templates in VISMA kml format
 *
 * @package stb\Accounting\Formatter
 */
class VISMAkml
{
    /**
     * End of line char
     */
    const EOL = "\r\n";

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
     *
     * @return void
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
     * @param string $kml Must be ISO-8859-1 charset
     *
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
                if (
                    !isset($values["Rad{$index}_konto"])
                    || !isset($values["Rad{$index}_belopp"])
                ) {
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
