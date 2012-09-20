<?php
namespace itbz\STB\Accounting;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class ChartOfTemplatesTest extends \PHPUnit_Framework_TestCase
{

    function testAdd()
    {
        $c = new ChartOfTemplates();
        $this->assertFalse($c->exists('T'));

        $T = new Template();
        $T->setId('T');
        $c->addTemplate($T);
        $this->assertTrue($c->exists('T'));

        $this->assertEquals($T, $c->getTemplate('T'));
        $templates = $c->getTemplates();
        $this->assertEquals($T, $templates['T']);
        
        $c->dropTemplate('T');
        $this->assertFalse($c->exists('T'));
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidTemplateException
     */
    function testTemplateDoesNotExistError()
    {
        $c = new ChartOfTemplates();
        $c->getTemplate('T');
    }


    function testExportImport()
    {
        $c = new ChartOfTemplates();
        $T = new Template();
        $T->setId('T');
        $c->addTemplate($T);

        $str = serialize($c);
        $c2 = unserialize($str);
 
        $this->assertTrue($c2->exists('T'));
        $this->assertEquals($T, $c2->getTemplate('T'));             
    }

}
