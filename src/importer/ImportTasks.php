<?php


namespace taskforce\importer;


class ImportTasks extends AbstractImporter
{

    protected function sqlExport(): void
    {
        foreach ($this->getData() as $row) {
            list($dt_add, $category_id, $description, $expire, $name, $address, $budget, $lat, $long) = $row;
            $this->query .= "INSERT INTO tasks (dt_add, deadline, user_id, category_id, city_id, status, name, description, cost)
VALUES ('$dt_add', '$expire', 8, $category_id, 1, 0, '$name', '$description', $budget); \n";
        }
        file_put_contents('sql/tasks.sql', $this->query);
    }
}
