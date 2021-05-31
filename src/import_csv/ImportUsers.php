<?php


namespace taskforce\import_csv;

use SplFileObject;

class ImportUsers extends AbstractImporter
{
    public function __construct()
    {
        $this->query = '';
        $this->pathCsv = 'data/users.csv';
        $this->pathSQL = 'sql/users.sql';
    }

    protected function convert(): void
    {
        $data = new SplFileObject($this->pathCsv);
        $data->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        foreach ($data as $row) {
            list($email, $name, $password, $dt_add) = $row;

            $this->query .= "INSERT INTO cities (email, name, password, dt_add) VALUES ($email, $name, $password, $dt_add); \n";
        }
    }
}
