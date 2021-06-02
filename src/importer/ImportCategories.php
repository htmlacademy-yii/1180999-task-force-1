<?php


namespace taskforce\importer;


class ImportCategories extends AbstractImporter
{
    protected function sqlExport(): void
    {
        foreach ($this->getData() as $row) {
            list($name, $code) = $row;
            $this->query .= "INSERT INTO categories (name, code) VALUES ('$name', '$code'); \n";
        }
        file_put_contents('sql/categories.sql', $this->query);
    }
}
