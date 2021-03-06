<?php

use Sunnysideup\DMS\Extensions\DMSTaxonomyTypeExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;

class DMSTaxonomyTypeExtensionTest extends SapphireTest
{
    protected $usesDatabase = true;

    protected static $required_extensions = array(
        'TaxonomyType' => array(DMSTaxonomyTypeExtension::class)
    );

    /**
     * Ensure that the configurable list of default records are created
     */
    public function testDefaultRecordsAreCreated()
    {
        Config::modify()->update(DMSTaxonomyTypeExtension::class, 'default_records', array('Food', 'Beverage', 'Books'));

        TaxonomyType::create()->requireDefaultRecords();

        $this->assertDOSContains(
            array(
                array('Name' => 'Food'),
                array('Name' => 'Beverage'),
                array('Name' => 'Books'),
            ),
            TaxonomyType::get()
        );
    }
}
