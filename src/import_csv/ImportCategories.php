<?php


namespace taskforce\import_csv;
use SplFileObject;

class ImportCategories extends AbstractImporter
{
    public function __construct()
    {
        $this->query = '';
        $this->pathCsv = 'data/categories.csv';
        $this->pathSQL = 'sql/categories.sql';
    }

    protected function convert(): void
    {
        $data = new SplFileObject($this->pathCsv);
        $data->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        foreach ($data as $row) {
            list($name, $code) = $row;
            $this->query .= "INSERT INTO cities (name, code) VALUES ($name, $code); \n";
        }
    }
}
