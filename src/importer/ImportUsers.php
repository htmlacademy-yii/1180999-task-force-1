<?php


namespace taskforce\importer;


class ImportUsers extends AbstractImporter
{

    protected function sqlExport(): void
    {
        foreach ($this->getData() as $row) {
            list($email, $name, $password, $dt_add, $address, $bd, $about, $phone, $skype) = $row;
            $this->query .= "INSERT INTO users (email, name, password, dt_add, contacts, birthday, about_me, phone, skype, city_id)
VALUES ('$email','$name','$password','$dt_add','$address','$bd','$about','$phone','$skype', 1); \n";
        }
        file_put_contents('sql/users.sql', $this->query);
    }
}

