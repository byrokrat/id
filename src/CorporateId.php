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
 * Swedish corporate identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CorporateId implements Id
{
    use Component\Structure, Component\CheckDigit, Component\SexualIdentity, Component\Stringify;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^(\d)(\d{5})[-](\d{3})(\d)$/';

    /**
     * @var string Group number
     */
    private $groupNr;

    /**
     * @var array Serial number in tow parts, pre and post delimiter
     */
    private $serialNr;

    /**
     * Set id number
     *
     * @param  string                     $id
     * @throws Exception\InvalidStructureException  If structure is invalid
     */
    public function __construct($id)
    {
        list(, $this->groupNr, $pre, $post, $check) = CorporateId::parseStructure($id);

        if ($pre[1] < 2) {
            throw new Exception\InvalidStructureException('Third digit must be at lest 2');
        }

        $this->serialNr = array($pre, $post);

        $this->setCheckDigit($check);
        $this->validateCheckDigit();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->groupNr
            . $this->serialNr[0]
            . $this->getDelimiter()
            . $this->serialNr[1]
            . $this->getCheckDigit();
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return '-';
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
        switch ($this->groupNr) {
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
