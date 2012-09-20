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
 *
 * @package STB\Accounting\Formatter
 */
namespace itbz\STB\Accounting\Formatter;
use itbz\STB\Accounting\Verification;
use itbz\STB\Accounting\ChartOfAccounts;
use itbz\STB\Accounting\Account;
use itbz\STB\Exception\VerificationNotBalancedException;
use itbz\STB\Exception\InvalidYearException;
use itbz\STB\Exception\InvalidChartException;
use DateTime;


/**
 * SIE 4I file format implementation.
 *
 * WARNING: This is not a complete implementation of the SIE file
 * format. Only subsection 4I is supported (transactions to be
 * imported into a regular accounting software). The porpuse is to
 * enable web applications to export transactions to accounting.
 *
 * This implementation is based on specification 4B from the
 * maintainer (SIE gruppen) dated 2008-09-30.
 *
 * @package STB\Accounting\Formatter
 */
class SIE
{

    /**
     * End of line chars used
     */
    const EOL = "\r\n";


    /**
     * Name of program generating SIE
     *
     * @var string
     */
    private $_program = "itbz_STB_SIE";


    /**
     * Version of program generating SIE
     *
     * @var string
     */
    private $_version = '1.0';


    /**
     * Name of person (instance) generating SIE
     *
     * @var string
     */
    private $_creator = 'itbz_STB_SIE';


    /**
     * Name of company whose verifications are beeing handled
     *
     * @var string
     */
    private $_company = "";


    /**
     * Start of accounting year
     *
     * @var DateTime
     */
    private $_yearStart;


    /**
     * End of accounting year
     *
     * @var DateTime
     */
    private $_yearStop;


    /**
     * Creation date
     *
     * @var DateTime
     */
    private $_date;


    /**
     * Type of chart of accounts used
     *
     * @var string
     */
    private $_typeOfChart = "EUBAS97";


    /**
     * Loaded verifications
     *
     * @var array
     */
    private $_verifications = array();


    /**
     * List of accounts used in loaded verifications
     *
     * @var array
     */
    private $_usedAccounts = array();


    /**
     * Create date at construct
     */
    public function __construct()
    {
        $this->_date = new DateTime();
    }


    /**
     * Clear added verifications
     *
     * @return void
     */
    public function clear()
    {
        $this->_verifications = array();
    }


    /**
     * Set name of generating program
     *
     * @param string $program
     *
     * @param string $version
     *
     * @return SIE instance for chaining
     */
    public function setProgram($program, $version)
    {
        assert('is_string($program)');
        assert('is_string($version)');
        $this->_program = $program;
        $this->_version = $version;

        return $this;
    }


    /**
     * Set creator name (normally logged in user or simliar)
     *
     * @param string $creator
     *
     * @return SIE instance for chaining
     */
    public function setCreator($creator)
    {
        assert('is_string($creator)');
        $this->_creator = $creator;

        return $this;
    }


    /**
     * Set name of company whose verifications are beeing handled
     *
     * @param string $company
     *
     * @return SIE instance for chaining
     */
    public function setCompany($company)
    {
        assert('is_string($company)');
        $this->_company = $company;

        return $this;
    }


    /**
     * Set accounting year
     *
     * @param DateTime $start Only date part is used
     *
     * @param DateTime $stop Only date part is used
     *
     * @return SIE instance for chaining
     */
    public function setYear(DateTime $start, DateTime $stop)
    {
        $start->setTime(0, 0, 0);
        $stop->setTime(23, 59, 59);
        $this->_yearStart = $start;
        $this->_yearStop = $stop;

        return $this;
    }


    /**
     * Set type of chart of accounts used
     *
     * @param string $typeOfChart
     *
     * @return SIE instance for chaining
     */
    public function setTypeOfChart($typeOfChart)
    {
        assert('is_string($typeOfChart)');
        $this->_typeOfChart = $typeOfChart;

        return $this;
    }


    /**
     * Add verification to SIE, verification MUST be balanced
     *
     * @param Verification $ver
     *
     * @return SIE Instance for chaining
     *
     * @throws VerificationNotBalancedException if $ver is unbalanced
     *
     * @throws InvalidYearException if $ver date is out of bounds
     */
    public function addVerification(Verification $ver)
    {
        // Verify that verification is balanced
        if (!$ver->isBalanced()) {
            $msg = "Verification '{$ver->getText()}' is not balanced";
            throw new VerificationNotBalancedException($msg);
        }
        
        // Verify that verification date matches accounting year
        if (isset($this->_yearStart)) {
            $verdate = $ver->getDate();
            if (
                $verdate < $this->_yearStart
                || $verdate > $this->_yearStop
            ) {
                $date = $verdate->format('Y-m-d');
                $msg = "Verification date '$date' is out of bounds";
                throw new InvalidYearException($msg);
            }
        }

        // Set names of used accounts
        foreach ($ver->getAccounts() as $account) {
            $nr = $account->getNumber();
            $this->_usedAccounts[$nr] = $account;  
        }
        
        // Save verification
        $this->_verifications[] = $ver;
        
        return $this;
    }


    /**
     * Remove control characters, addslashes and quote $str
     *
     * @param string $str
     *
     * @return string
     */
    static public function quote($str)
    {
        assert('is_string($str)');
        $str = preg_replace('/[[:cntrl:]]/', '', $str);
        $str = addslashes($str);

        return "\"$str\"";
    }


    /**
     * Generate SIE string (using charset CP437)
     *
     * @return string 
     */
    public function generate()
    {
        // Generate header
        $program = self::quote($this->_program);
        $version = self::quote($this->_version);
        $creator = self::quote($this->_creator);
        $company = self::quote($this->_company);
        $chartType = self::quote($this->_typeOfChart);

        $sie = "#FLAGGA 0" . self::EOL;
        $sie .= "#PROGRAM $program $version" . self::EOL;
        $sie .= "#FORMAT PC8" . self::EOL;
        $sie .= "#GEN {$this->_date->format('Ymd')} $creator" . self::EOL;
        $sie .= "#SIETYP 4" . self::EOL;
        $sie .= "#FNAMN $company" . self::EOL;
        $sie .= "#KPTYP $chartType" . self::EOL;

        if (isset($this->_yearStart)) {
            $start = $this->_yearStart->format('Ymd');
            $stop = $this->_yearStop->format('Ymd');
            $sie .= "#RAR 0 $start $stop" . self::EOL;
        }

        $sie .= self::EOL;

        // Generate accounts
        foreach ($this->_usedAccounts as $account) {
            $number = self::quote($account->getNumber());
            $name = self::quote($account->getName());
            $type = self::quote($account->getType());
            $sie .= "#KONTO $number $name" . self::EOL;
            $sie .= "#KTYP $number $type" . self::EOL;
        }

        // Generate verifications
        foreach ($this->_verifications as $ver) {
            $text = self::quote($ver->getText());
            $date = $ver->getDate()->format('Ymd');
            $sie .= self::EOL . "#VER \"\" \"\" $date $text" . self::EOL;
            $sie .= "{" . self::EOL;
            foreach ($ver->getTransactions() as $trans) {
                $sie .=
                    "\t#TRANS {$trans->getAccount()->getNumber()} {} "
                    . $trans->getAmount()
                    . self::EOL;
            }
            $sie .= "}" . self::EOL;
        }

        // Convert charset
        $sie = iconv("UTF-8", "CP437", $sie);

        return $sie;
    }


    /**
     * Generate SIE string (using charset CP437) for $chart
     *
     * @param string $description String describing this chart of accounts
     *
     * @param ChartOfAccounts $chart
     *
     * @return string 
     */
    public function exportChart($description, ChartOfAccounts $chart)
    {
        assert('is_string($description)');
    
        // Generate header
        $program = self::quote($this->_program);
        $description = self::quote($description);
        $version = self::quote($this->_version);
        $creator = self::quote($this->_creator);
        $chartType = self::quote($chart->getChartType());

        $sie = "#FILTYP KONTO" . self::EOL;
        $sie .= "#PROGRAM $program $version" . self::EOL;
        $sie .= "#TEXT $description" . self::EOL;
        $sie .= "#FORMAT PC8" . self::EOL;
        $sie .= "#GEN {$this->_date->format('Ymd')} $creator" . self::EOL;
        $sie .= "#KPTYP $chartType" . self::EOL;

        $sie .= self::EOL;

        // Generate accounts
        foreach ( $chart->getAccounts() as $account ) {
            $number = self::quote($account->getNumber());
            $name = self::quote($account->getName());
            $type = self::quote($account->getType());
            $sie .= "#KONTO $number $name" . self::EOL;
            $sie .= "#KTYP $number $type" . self::EOL;
        }

        // Convert charset
        $sie = iconv("UTF-8", "CP437", $sie);

        return $sie;
    }


    /**
     * Create a ChartOfAccounts object from SIE string (in charset CP437)
     *
     * @param string $sie
     *
     * @return ChartOfAccounts
     *
     * @throws InvalidChartException If $sie is not valid
     */
    public function importChart($sie)
    {
        $sie = iconv("CP437", "UTF-8", $sie);
        $lines = explode(self::EOL, $sie);

        $chart = new ChartOfAccounts();
        $current = array();

        foreach ( $lines as $nr => $line ) {
            $data = str_getcsv($line, ' ', '"');
            switch ( $data[0] ) {
                case '#KPTYP':
                    if ( !isset($data[1]) ) {
                        $msg = "Invalid chart type at line $nr";
                        throw new InvalidChartException($msg);
                    }
                    $chart->setChartType($data[1]);
                    break;

                case '#KONTO':
                    // Account must have form #KONTO number name
                    if ( !isset($data[2]) ) {
                        $msg = "Invalid account values at line $nr";
                        throw new InvalidChartException($msg);
                    }
                    $current = array($data[1], $data[2]);
                    break;
                
                case '#KTYP':
                    // Account type must have form #KTYP number type
                    if ( !isset($data[2]) ) {
                        $msg = "Invalid account values at line $nr";
                        throw new InvalidChartException($msg);
                    }
                    // Type must referer to current account
                    if ( $data[1] != $current[0] ) {
                        $msg = "Unexpected account type at line $nr";
                        throw new InvalidChartException($msg);
                    }                    
                    $account = new Account($data[1], $data[2], $current[1]);
                    $chart->addAccount($account);
                    $current = array();
                    break;            
            }
        }
        
        // There should be no half way processed accounts
        if ( !empty($current) ) {
            $msg = "Account type missing for '{$current[0]}'";
            throw new InvalidChartException($msg);
        }
        
        return $chart;
    }

}
