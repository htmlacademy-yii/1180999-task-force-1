<?php


namespace taskforce\import_csv;
use SplFileObject;

class ImportCities extends AbstractImporter
{
    public function __construct()
    {
        $this->query = '';
        $this->pathCsv = 'data/cities.csv';
        $this->pathSQL = 'sql/cities.sql';
    }

    protected function convert(): void
    {
        $data = new SplFileObject($this->pathCsv);
        $data->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        foreach ($data as $row) {
            list($city, $lat, $long) = $row;
            $this->query .= "INSERT INTO cities (name, latitude, longitude) VALUES ($city, $lat, $long); \n";
        }
    }
}
