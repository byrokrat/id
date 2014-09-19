<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Swedish organizational identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class OrganizationId implements Id
{
    use Component\Structure, Component\Base, Component\Date, Component\SexualIdentity, Component\Format;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^(\d{6})[-]?(\d{3})(\d)$/';

    /**
     * Set id number
     *
     * @param  string $id
     * @throws Exception\InvalidStructureException If structure is invalid
     */
    public function __construct($id)
    {
        list(, $this->serialPre, $this->serialPost, $this->checkDigit) = OrganizationId::parseStructure($id);

        if ($this->serialPre[2] < 2) {
            throw new Exception\InvalidStructureException('Third digit must be at lest 2');
        }

        $this->validateCheckDigit();
    }

    /**
     * Get string describing corporate group
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the corporation
     *
     * @return string
     */
    public function getGroupDescription()
    {
        switch ($this->serialPre[0]) {
            case "2":
                return "Stat, landsting, kommun eller församling";
            case "5":
                return "Aktiebolag";
            case "6":
                return "Enkelt bolag";
            case "7":
                return "Ekonomisk förening";
            case "8":
                return "Ideell förening eller stiftelse";
            case "9":
                return "Handelsbolag, kommanditbolag eller enkelt bolag";
            default:
                return "Okänd";
        }
    }
}
