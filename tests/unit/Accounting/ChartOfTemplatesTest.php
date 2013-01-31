<?php
namespace iio\stb\Accounting;

class ChartOfTemplatesTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
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
     * @expectedException iio\stb\Exception\InvalidTemplateException
     */
    public function testTemplateDoesNotExistError()
    {
        $c = new ChartOfTemplates();
        $c->getTemplate('T');
    }

    public function testExportImport()
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
