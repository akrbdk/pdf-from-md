<?php

namespace tests\tests;

use Akrbdk\PdfFromMd\FileProcessor;
use PHPUnit\Framework\TestCase;

class FileProcessorTest extends TestCase
{
    public function testGetFileListWithoutChapters()
    {
        $processor = new FileProcessor(__DIR__ . '/mock-files', 'md', false);
        $files = $processor->getSortedListOfFiles();
        $this->assertCount(3, $files);
        $this->assertStringEndsWith('1.md', $files[0]);
    }

    public function testGetFileListWithChapters()
    {
        $processor = new FileProcessor(__DIR__ . '/mock-files', 'md', true);
        $files = $processor->getSortedListOfFiles();
        $this->assertCount(6, $files);
        $this->assertStringEndsWith('1/1.md', $files[0]);
    }
}
