<?php


namespace taskforce\importer;

use SplFileObject;
use taskforce\exceptions\FileImportException;

class ImportReviews extends AbstractImporter
{
    protected string $exportFile = 'sql/reviews.sql';

    protected function exportFile(): void
    {
        if (file_exists($this->exportFile)) {
            if (!is_writable($this->exportFile)) {
                throw new FileImportException('Ошибка записи в файл');
            }
        }

        $handle = new SplFileObject($this->exportFile, 'w');
        foreach ($this->getData() as $row) {
            list($dt_add, $rate, $description) = $row;
            $handle->fwrite("INSERT INTO reviews (dt_add, executor_id, task_id, score, text) VALUES ('$dt_add', 8, 8, $rate, '$description'); \n");
        }
    }
}
