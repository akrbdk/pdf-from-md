<?php

namespace Akrbdk\PdfFromMd;

class FileProcessor
{
    private string $rootPath;
    private string $fileExtension;
    private bool $useChapterFolders;

    public function __construct(string $rootPath, string $fileExtension = 'md', bool $useChapterFolders = false)
    {
        $this->rootPath = rtrim($rootPath, '/\\') . '/';
        $this->fileExtension = $fileExtension;
        $this->useChapterFolders = $useChapterFolders;
    }

    public function getSortedListOfFiles(): array
    {
        $sortedFiles = [];

        if ($this->useChapterFolders) {
            $chapters = array_filter(glob($this->rootPath . '*'), 'is_dir');
            $chapters = $this->sortList($chapters);

            foreach ($chapters as $chapter) {
                $chapterFiles = glob("$chapter/*." . $this->fileExtension);
                $chapterFiles = $this->sortList($chapterFiles);
                $sortedFiles = array_merge($sortedFiles, $chapterFiles);
            }
        } else {
            $allFiles = glob($this->rootPath . "*." . $this->fileExtension);
            $sortedFiles = $this->sortList($allFiles);
        }

        return $sortedFiles;
    }

    private function sortList(array $list): array
    {
        usort($list, function ($a, $b) {
            $indexA = (int) preg_replace('/\D/', '', $a);
            $indexB = (int) preg_replace('/\D/', '', $b);
            return $indexA <=> $indexB;
        });

        return $list;
    }

    public function generatePDF(array $fileList, string $outputFile = 'book.pdf'): void
    {
        if (empty($fileList)) {
            echo "No markdown files found. Check your folder structure or options.\n";
            exit;
        }

        $fileListString = implode(' ', array_map('escapeshellarg', $fileList));
        $outputFilePath = $this->rootPath . $outputFile;
        $pandocCommand = "pandoc --pdf-engine=xelatex --toc -o $outputFilePath $fileListString";

        $this->runCommand($pandocCommand);
    }

    private function runCommand(string $command): void
    {
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            echo "Error executing command: $command\n";
            exit($returnVar);
        }
    }
}