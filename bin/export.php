<?php

// Main script execution
use Akrbdk\PdfFromMd\FileProcessor;

$options = getopt("p:c::f::", ["root-path:", "using-chapter-folders::", "file-extension::"]);

$rootPath = $options['p'] ?? $options['root-path'] ?? null;
$fileExtension = $options['f'] ?? $options['file-extension'] ?? 'md';
$useChapterFolders = isset($options['c']) || isset($options['using-chapter-folders']);

if (!$rootPath) {
    echo "Usage: php script.php -p <root-path> [-c] [-f <file-extension>]\n";
    exit(1);
}

$processor = new FileProcessor($rootPath, $fileExtension, $useChapterFolders);
$fileList = $processor->getSortedListOfFiles();

foreach ($fileList as $file) {
    echo $file . "\n";
}

$processor->generatePDF($fileList);