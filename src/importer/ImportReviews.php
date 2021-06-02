<?php


namespace taskforce\importer;


class ImportReviews extends AbstractImporter
{
    protected function sqlExport(): void
    {
        foreach ($this->getData() as $row) {
            list($dt_add, $rate, $description) = $row;
            $this->query .= "INSERT INTO reviews (dt_add, executor_id, task_id, score, text)
VALUES ('$dt_add', 8, 13, $rate, '$description'); \n";
        }
        file_put_contents('sql/reviews.sql', $this->query);
    }
}
