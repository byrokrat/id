<?php
namespace itbz\STB\Accounting\Formatter;

use DateTime;
use itbz\STB\Accounting\Verification;
use itbz\STB\Accounting\Transaction;
use itbz\STB\Accounting\ChartOfAccounts;
use itbz\STB\Accounting\Account;
use itbz\STB\Utils\Amount;

class SIETest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException itbz\STB\Exception\VerificationNotBalancedException
     */
    public function testUnbalancedVerification()
    {
        $sie = new SIE();
        $v = new Verification('testver');
        $v->addTransaction(new Transaction(new Account('1920', 'T', 'Bank'), new Amount('100', 2)));
        $v->addTransaction(new Transaction(new Account('3000', 'I', 'Income'), new Amount('-50', 2)));
        $sie->addVerification($v);
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidYearException
     */
    public function testAccountingYearError()
    {
        $sie = new SIE();
        $sie->setYear(new DateTime('2012-01-01'), new DateTime('2012-12-31'));
        $v = new Verification('testver', new DateTime('2013-01-01'));
        $sie->addVerification($v);
    }

    public function testSetProgram()
    {
        $sie = new SIE();
        $sie->setProgram('foo"bar', "1.\n0");
        $txt = $sie->generate();
        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"foo\\\"bar\" \"1.0\"\r\n#FORMAT PC8"
            ."\r\n#GEN $date \"itbz_STB_SIE\"\r\n#SIETYP 4\r\n#FNAMN \"\"\r\n"
            ."#KPTYP \"EUBAS97\"\r\n\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);
        $this->assertEquals($txt, $expected);
    }

    public function testSetCreator()
    {
        $sie = new SIE();
        $sie->setCreator('foo');
        $txt = $sie->generate();
        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#FORMAT"
            ." PC8\r\n#GEN $date \"foo\"\r\n#SIETYP 4\r\n#FNAMN \"\"\r\n#KPTYP"
            ." \"EUBAS97\"\r\n\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);
        $this->assertEquals($txt, $expected);
    }

    public function testSetCompany()
    {
        $sie = new SIE();
        $sie->setCompany('foo');
        $txt = $sie->generate();
        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#FORMAT"
           ." PC8\r\n#GEN $date \"itbz_STB_SIE\"\r\n#SIETYP 4\r\n#FNAMN \"foo\""
            ."\r\n#KPTYP \"EUBAS97\"\r\n\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);
        $this->assertEquals($txt, $expected);
    }

    public function testSetYear()
    {
        $sie = new SIE();
        $sie->setYear(new DateTime('2013-01-01'), new DateTime('2013-12-31'));
        $txt = $sie->generate();
        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#FORMAT"
            ." PC8\r\n#GEN $date \"itbz_STB_SIE\"\r\n#SIETYP 4\r\n#FNAMN \"\""
            ."\r\n#KPTYP \"EUBAS97\"\r\n#RAR 0 20130101 20131231\r\n\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);
        $this->assertEquals($txt, $expected);
    }

    public function testsetTypeOfChart()
    {
        $sie = new SIE();
        $sie->setCompany('foo');
        $sie->setTypeOfChart('BAS96');
        $txt = $sie->generate();
        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#FORMAT"
            ." PC8\r\n#GEN $date \"itbz_STB_SIE\"\r\n#SIETYP 4\r\n#FNAMN \"foo"
            ."\"\r\n#KPTYP \"BAS96\"\r\n\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);
        $this->assertEquals($txt, $expected);
    }

    public function testGenerate()
    {
        $sie = new SIE();
        $year = date('Y');
        $sie->setYear(new DateTime("$year-01-01"), new DateTime("$year-12-31"));

        $v = new Verification('testver');
        $v->addTransaction(new Transaction(new Account('1920', 'T', 'Bank'), new Amount('100', 2)));
        $v->addTransaction(new Transaction(new Account('3000', 'I', 'Income'), new Amount('-100', 2)));
        $sie->addVerification($v);

        $txt = $sie->generate();

        $date = date('Ymd');
        $expected = "#FLAGGA 0\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#FORMAT"
            ." PC8\r\n#GEN $date \"itbz_STB_SIE\"\r\n#SIETYP 4\r\n#FNAMN \"\""
            ."\r\n#KPTYP \"EUBAS97\"\r\n#RAR 0 {$year}0101 {$year}1231\r\n\r\n"
            ."#KONTO \"1920\" \"Bank\"\r\n#KTYP \"1920\" \"T\"\r\n#KONTO \"3000"
            ."\" \"Income\"\r\n#KTYP \"3000\" \"I\"\r\n"
            ."\r\n#VER \"\" \"\" $date \"testver\"\r\n{\r\n"
            ."\t#TRANS 1920 {} 100.00\r\n"
            ."\t#TRANS 3000 {} -100.00\r\n"
            ."}\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);

        $this->assertEquals($expected, $txt);
    }

    public function testExportChart()
    {
        $chart = new ChartOfAccounts();
        $chart->addAccount(new Account('1920', 'T', 'Bank'));
        $chart->addAccount(new Account('3000', 'I', 'Income'));

        $sie = new SIE();
        $txt = $sie->exportChart('FOOBAR', $chart);

        $date = date('Ymd');
        $expected = "#FILTYP KONTO\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#TEXT"
            ." \"FOOBAR\"\r\n#FORMAT PC8\r\n#GEN $date \"itbz_STB_SIE\"\r\n#KPTYP"
            ." \"EUBAS97\"\r\n\r\n"
            ."#KONTO \"1920\" \"Bank\"\r\n#KTYP \"1920\" \"T\"\r\n#KONTO \"3000\""
            ." \"Income\"\r\n#KTYP \"3000\" \"I\"\r\n";
        $expected = iconv("UTF-8", "CP437", $expected);

        $this->assertEquals($expected, $txt);
    }

    public function testImportChart()
    {
        $siestr = "#FILTYP KONTO\r\n#PROGRAM \"itbz_STB_SIE\" \"1.0\"\r\n#TEXT"
            ." \"FOOBAR\"\r\n#FORMAT PC8\r\n#GEN 20120430 \"itbz_STB_SIE\"\r\n"
            ."#KPTYP \"BAS2010\"\r\n\r\n"
            ."#KONTO \"1920\" \"Bank\"\r\n#KTYP \"1920\" \"T\"\r\n#KONTO \""
            ."3000\" \"Income\"\r\n#KTYP \"3000\" \"I\"\r\n";
        $siestr = iconv("UTF-8", "CP437", $siestr);

        $sie = new SIE();
        $chart = $sie->importChart($siestr);

        $this->assertEquals('BAS2010', $chart->getChartType());

        $expected = array(
            '1920' => new Account('1920', 'T', 'Bank'),
            '3000' => new Account('3000', 'I', 'Income')
        );
        $this->assertEquals($expected, $chart->getAccounts());
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidChartException
     */
    public function testImportChartInvalidChartType()
    {
        $siestr = "#FILTYP KONTO\r\n#KPTYP";
        $siestr = iconv("UTF-8", "CP437", $siestr);
        $sie = new SIE();
        $sie->importChart($siestr);
    }

    public function invalidSieAccountStringProvider()
    {
        return array(
            array("#KONTO \"1920\"\r\n#KTYP \"1920\" \"T\""),
            array("#KONTO \"1920\" \"Bank\"\r\n#KTYP \"1920\""),
            array("#KONTO \"1920\" \"Bank\"\r\n#KTYP \"1510\" \"T\""),
            array("#KONTO \"1920\" \"Bank\""),
        );
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidChartException
     * @dataProvider invalidSieAccountStringProvider
     */
    public function testImportChartInvalidAccount($account)
    {
        $siestr = "#FILTYP KONTO\r\n#KPTYP \"BAS2010\"\r\n";
        $siestr .= $account;
        $siestr = iconv("UTF-8", "CP437", $siestr);
        $sie = new SIE();
        $sie->importChart($siestr);
    }

    public function testClear()
    {
        $sie = new SIE();
        $v = new Verification('testver');
        $v->addTransaction(new Transaction(new Account('1920', 'T', 'Bank'), new Amount('100', 2)));
        $v->addTransaction(new Transaction(new Account('3000', 'I', 'Income'), new Amount('-100', 2)));
        $sie->addVerification($v);
        $sie->clear();
        $this->assertEquals(0, preg_match('/#VER/', $sie->generate()));
    }
}
