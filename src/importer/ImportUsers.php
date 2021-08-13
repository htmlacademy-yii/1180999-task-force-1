<?php


namespace taskforce\importer;

use SplFileObject;
use taskforce\exceptions\FileImportException;

class ImportUsers extends AbstractImporter
{
    protected string $exportFile = 'sql/users.sql';

    protected function exportFile(): void
    {
        if (file_exists($this->exportFile)) {
            if (!is_writable($this->exportFile)) {
                throw new FileImportException('Ошибка записи в файл');
            }
        }

        $handle = new SplFileObject($this->exportFile, 'w');
        foreach ($this->getData() as $row) {
            list($email, $name, $password, $dt_add, $address, $bd, $about, $phone, $skype) = $row;
            $handle->fwrite("INSERT INTO users (email, name, password, dt_add, contacts, birthday, about_me, phone, skype, city_id)
VALUES ('$email','$name','$password','$dt_add','$address','$bd','$about','$phone','$skype', 1); \n");
        }
    }
}

