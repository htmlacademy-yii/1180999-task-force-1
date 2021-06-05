<?php


namespace taskforce\importer;

use SplFileObject;
use taskforce\exceptions\FileImportException;

class ImportCategories extends AbstractImporter
{
    protected string $exportFile = 'sql/categories.sql';

    protected function exportFile(): void
    {
        if (file_exists($this->exportFile)) {
            if (!is_writable($this->exportFile)) {
                throw new FileImportException('Ошибка записи в файл');
            }
        }

        $handle = new SplFileObject($this->exportFile, 'w');
        foreach ($this->getData() as $row) {
            list($name, $code) = $row;
            $handle->fwrite("INSERT INTO categories (name, code) VALUES ('$name', '$code'); \n");
        }
    }
}
