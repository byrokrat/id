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

class VISMAkmlTest extends \PHPUnit_Framework_TestCase
{
    public function testExport()
    {
        $kml = new VISMAkml();

        $t1 = new Template('id', 'fooname', 'foobar');
        $t1->addTransaction('1920', '450');
        $t1->addTransaction('3000', '-450');
        $kml->addTemplate($t1);

        $t2 = new Template('id2', 'åäö', 'foobar');
        $t2->addTransaction('1920', '{amount}');
        $t2->addTransaction('3000', '-{amount}');
        $kml->addTemplate($t2);

        $str = $kml->export();
        $expected = "[KontMall0]\r\nid=id\r\nnamn=fooname\r\ntext=foobar\r\n"
            ."Rad0_radnr=1\r\nRad0_konto=1920\r\nRad0_belopp=450\r\nRad1_radnr=2"
            ."\r\nRad1_konto=3000\r\nRad1_belopp=-450\r\n[KontMall1]\r\nid=id2"
            ."\r\nnamn=åäö\r\ntext=foobar\r\nRad0_radnr=1\r\nRad0_konto=1920"
            ."\r\nRad0_belopp={amount}\r\nRad1_radnr=2\r\nRad1_konto=3000\r\n"
            ."Rad1_belopp=-{amount}\r\n";
        $expected = iconv("UTF-8", "ISO-8859-1", $expected);
        $this->assertEquals($expected, $str);
    }

    public function testImport()
    {
        $kml = new VISMAkml();
        $raw = "[KontMall0]\r\nid=id\r\nnamn=fooname\r\ntext=foobar\r\n"
            ."Rad0_radnr=1\r\nRad0_konto=1920\r\nRad0_belopp=450\r\n"
            ."Rad1_radnr=2\r\nRad1_konto=3000\r\nRad1_belopp=-450\r\n"
            ."[KontMall1]\r\nid=id2\r\nnamn=fooname\r\ntext=foobar\r\n"
            ."Rad0_radnr=1\r\nRad0_konto=1920\r\nRad0_belopp={amount}\r\n"
            ."Rad1_radnr=2\r\nRad1_konto=3000\r\nRad1_belopp=-{amount}\r\n";
        $kml->import($raw);

        $t1 = new Template('id', 'fooname', 'foobar');
        $t1->addTransaction('1920', '450');
        $t1->addTransaction('3000', '-450');

        $t2 = new Template('id2', 'fooname', 'foobar');
        $t2->addTransaction('1920', '{amount}');
        $t2->addTransaction('3000', '-{amount}');

        $expected = array(
            'id' => $t1,
            'id2' => $t2
        );
        $this->assertEquals($expected, $kml->getTemplates());
    }

    public function testImportRealData()
    {
        $fname = realpath(__DIR__ . '/../../data/templates.kml');
        $raw = file_get_contents($fname);
        $kml = new VISMAkml();
        $kml->import($raw);

        // Build representation in file
        $AA = new Template();
        $AA->setId('AA');
        $AA->setName('Inbetald AA-avgift');
        $AA->setText('Medl.fakt. {F-nr} ({M-nr}) ({OCR}) åäö');
        $AA->addTransaction('3000', '-450');
        $AA->addTransaction('4110', '{SAC-AA}');
        $AA->addTransaction('2421', '-{SAC-AA}');
        $AA->addTransaction('4120', '{Sodra-AA}');
        $AA->addTransaction('2422', '-{Sodra-AA}');
        $AA->addTransaction('{Betkanal}', '{Summa}');

        $AA1 = new Template();
        $AA1->setId('AA1');
        $AA1->setName('Inbetald AA-avgift');
        $AA1->setText('Medl.fakt. {F-nr} ({M-nr}) ({OCR})');
        $AA1->addTransaction('3000', '-450');
        $AA1->addTransaction('4110', '{SAC-AA}');
        $AA1->addTransaction('2421', '-{SAC-AA}');
        $AA1->addTransaction('4120', '{Sodra-AA}');
        $AA1->addTransaction('2422', '-{Sodra-AA}');
        $AA1->addTransaction('{Betkanal}', '{Summa}');

        $expected = array(
            'AA' => $AA,
            'AA1' => $AA1
        );

        // Assert equality
        $this->assertEquals($expected, $kml->getTemplates());
    }
}
