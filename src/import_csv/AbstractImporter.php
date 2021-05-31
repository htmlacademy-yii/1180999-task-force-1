<?php


namespace taskforce\import_csv;
use Exception;

abstract class AbstractImporter
{
    protected string $pathCsv;
    protected string $pathSQL;
    protected string $query;

    abstract protected function convert(): void;

    protected function eraseHeader(): void
    {
        $fd = fopen($this->pathSQL, 'r');
        $tm = fopen($tmpname = tempnam('.', 'list'), 'w+');
        if ($fd === false) {
            throw new Exception('Не могу открыть целевой файл');
        }
        if ($tm === false) {
            throw new Exception('Не могу открыть временный файл');
        }

        $i = 0;
        while (($line = fgets($fd)) !== false) {
            if (++$i == 1) continue;
            fwrite($tm, $line);
        }
        fclose($fd);
        fclose($tm);
        rename($tmpname, $this->pathSQL);
    }

    public function import()
    {
        $this->convert();
        file_put_contents($this->pathSQL, $this->query);
        $this->eraseHeader();
    }


}
