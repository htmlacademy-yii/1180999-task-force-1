<?php


namespace taskforce\importer;

use SplFileObject;
use taskforce\exceptions\FileImportException;

class ImportTasks extends AbstractImporter
{
    protected string $exportFile = 'sql/tasks.sql';

    protected function exportFile(): void
    {
        if (file_exists($this->exportFile)) {
            if (!is_writable($this->exportFile)) {
                throw new FileImportException('Ошибка записи в файл');
            }
        }

        $handle = new SplFileObject($this->exportFile, 'w');
        foreach ($this->getData() as $row) {
            list($dt_add, $category_id, $description, $expire, $name, $address, $budget, $lat, $long) = $row;
            $handle->fwrite("INSERT INTO tasks (dt_add, deadline, user_id, category_id, city_id, status, name, description, cost)
VALUES ('$dt_add', '$expire', 8, $category_id, 1, 0, '$name', '$description', $budget); \n");
        }
    }
}
