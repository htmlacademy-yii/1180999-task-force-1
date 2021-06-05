<?php


namespace taskforce\importer;

use SplFileObject;
use taskforce\exceptions\FileImportException;

class ImportCities extends AbstractImporter
{
    protected string $exportFile = 'sql/cities.sql';

    protected function exportFile(): void
    {
        if (file_exists($this->exportFile)) {
            if (!is_writable($this->exportFile)) {
                throw new FileImportException('Ошибка записи в файл');
            }
        }

        $handle = new SplFileObject($this->exportFile, 'w');
        foreach ($this->getData() as $row) {
            list($name, $lat, $long) = $row;
            $handle->fwrite("INSERT INTO cities (name, latitude, longitude) VALUES ('$name', $lat, $long); \n");
        }
    }
}

