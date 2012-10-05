<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package STB\Accounting
 */

namespace itbz\STB\Accounting;

use itbz\STB\Exception\InvalidStructureException;
use itbz\STB\Exception\InvalidTemplateException;
use itbz\STB\Utils\Amount;

/**
 * Simple accounting template class
 *
 * @package STB\Accounting
 */
class Template
{
    /**
     * Template id
     *
     * @var string
     */
    private $id;

    /**
     * Template name
     *
     * @var string
     */
    private $name;

    /**
     * Raw verification text
     *
     * @var string
     */
    private $text;

    /**
     * Raw template transactions
     *
     * @var array
     */
    private $transactions = array();

    /**
     * Optionaly set id, name and text
     *
     * @param string $id
     * @param string $name
     * @param string $text
     */
    public function __construct($id = '', $name = '', $text = '')
    {
        $this->setId($id);
        $this->setName($name);
        $this->setText($text);
    }

    /**
     * Set template id
     *
     * @param string $id
     *
     * @return void
     *
     * @throws InvalidTemplateException if id is longer than 6 characters
     */
    public function setId($id)
    {
        assert('is_string($id)');
        $id = trim($id);
        if (mb_strlen($id) > 6) {
            $msg = "Invalid template id '$id'. Use max 6 characters.";
            throw new InvalidTemplateException($msg);
        }
        $this->id = $id;
    }

    /**
     * Get template id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set template name
     *
     * @param string $name
     *
     * @return void
     *
     * @throws InvalidTemplateException if name is longer than 20 characters
     */
    public function setName($name)
    {
        assert('is_string($name)');
        $name = trim($name);
        if (mb_strlen($name) > 20) {
            $msg = "Invalid template name '$name'. Use max 20 characters.";
            throw new InvalidTemplateException($msg);
        }
        $this->name = $name;
    }

    /**
     * Get template name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set template text
     *
     * @param string $text
     *
     * @return void
     *
     * @throws InvalidTemplateException if text is longer than 60 characters
     */
    public function setText($text)
    {
        assert('is_string($text)');
        $text = trim($text);
        if (mb_strlen($text) > 60) {
            $msg = "Invalid template text '$text'. Use max 60 characters.";
            throw new InvalidTemplateException($msg);
        }
        $this->text = $text;
    }

    /**
     * Get template text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Add transaction data
     *
     * @param string $number
     * @param string $amount
     *
     * @return void
     */
    public function addTransaction($number, $amount)
    {
        assert('is_string($number)');
        assert('is_string($amount)');
        $number = trim($number);
        $amount = trim($amount);
        $this->transactions[] = array($number, $amount);
    }

    /**
     * Get loaded transaction data
     *
     * @return array
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Check if template is ready for conversion
     *
     * If all variables are substituted
     *
     * @param string &$key Will contian non-substituted key on error
     *
     * @return bool
     */
    public function ready(&$key)
    {
        foreach ($this->transactions as $arTransData) {
            foreach ($arTransData as $data) {
                if (preg_match("/\{[^}]*\}/", $data)) {
                    $key = $data;

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Apply list of substitutions to template
     *
     * @param array $values Substitution key-value-pairs
     *
     * @return void
     */
    public function substitute(array $values)
    {
        // Create map of substitution keys
        $keys = array_map(
            function ($val) {
                return '{' . $val . '}';
            },
            array_keys($values)
        );

        // Substitute terms in verification text
        $this->text = trim(str_replace($keys, $values, $this->text));

        // Substitue terms in transactions
        $this->transactions = array_map(
            function ($data) use ($keys, $values) {
                $data[0] = trim(str_replace($keys, $values, $data[0]));
                $data[1] = trim(str_replace($keys, $values, $data[1]));
                return $data;
            },
            $this->transactions
        );
    }

    /**
     * Create verification from template
     *
     * @param ChartOfAccounts $chart
     *
     * @return Verification
     *
     * @throws InvalidStructureException if any substitution key is NOT
     * substituted
     */
    public function buildVerification(ChartOfAccounts $chart)
    {
        if (!$this->ready($key)) {
            $msg = "Unable to substitute template key '$key'";
            throw new InvalidStructureException($msg);
        }

        // Build verification
        $ver = new Verification($this->getText());
        foreach ($this->getTransactions() as $arTransData) {
            list($number, $amount) = $arTransData;

            // Ignore 0 amount transactions
            $amount = floatval($amount);
            if ($amount != 0) {
                $account = $chart->getAccount($number);
                $amount = new Amount($amount);
                $ver->addTransaction(new Transaction($account, $amount));
            }
        }

        return $ver;
    }
}
