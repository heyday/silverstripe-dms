<?php

use SilverStripe\Core\Config\Config;
use Sunnysideup\DMS\DMS;
use Sunnysideup\DMS\Model\DMSDocumentController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;

/**
 * Class DMSDocumentControllerTest
 */
class DMSDocumentControllerTest extends SapphireTest
{
    protected static $fixture_file = 'dmstest.yml';

    /**
     * @var DMSDocumentController
     */
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        Config::modify()->update(DMS::class, 'folder_name', 'assets/_unit-test-123');
        $this->logInWithPermission('ADMIN');

        $this->controller = $this->getMockBuilder(DMSDocumentController::class)
            ->setMethods(['sendFile'])
            ->getMock();
    }

    public function tearDown(): void
    {
        DMSFilesystemTestHelper::delete('assets/_unit-test-123');
        parent::tearDown();
    }
    //
    // /**
    //  * Test that the download behaviour is either "open" or "download"
    //  *
    //  * @param string $behaviour
    //  * @param string $expectedDisposition
    //  * @dataProvider behaviourProvider
    //  */
    // public function testDownloadBehaviourOpen($behaviour, $expectedDisposition)
    // {
    //     $self = $this;
    //     $this->controller->expects($this->once())
    //         ->method('sendFile')
    //         ->will(
    //             $this->returnCallback(function ($path, $mime, $name, $disposition) use ($self, $expectedDisposition) {
    //                 $self->assertEquals($expectedDisposition, $disposition);
    //             })
    //         );
    //
    //     $openDoc = DMS::inst()->storeDocument('dms/tests/DMS-test-lorum-file.pdf');
    //     $openDoc->DownloadBehavior = $behaviour;
    //     $openDoc->clearEmbargo(false);
    //     $openDoc->write();
    //
    //     $request = new HTTPRequest('GET', $openDoc->Link());
    //     $request->match('dmsdocument/$ID');
    //     $this->controller->index($request);
    // }

    /**
     * @return array[]
     */
    public function behaviourProvider()
    {
        return [
            ['open', 'inline'],
            ['download', 'attachment']
        ];
    }
}
