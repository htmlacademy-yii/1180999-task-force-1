<?php


namespace taskforce\importer;

class ImportCities extends AbstractImporter
{
    protected function sqlExport(): void
    {
        foreach ($this->getData() as $row) {
            list($name, $lat, $long) = $row;
            $this->query .= "INSERT INTO cities (name, latitude, longitude) VALUES ('$name', $lat, $long); \n";
        }
        file_put_contents('sql/cities.sql', $this->query);
    }
}

