<?php


namespace taskforce\importer;


use SplFileObject;
use Exception;
use taskforce\exceptions\FileImportException;

abstract class AbstractImporter
{
    protected string $filename;
    protected array $columns;
    protected object $fileObject;

    protected string $query = '';
    protected array $result = [];

    /**
     * AbstractImporter constructor.
     * @param string $filename путь к исходному файлу CSV
     * @param array $columns массив из полей таблицы
     */
    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    /**
     * Преобразовывает файлы CSV в SQL и размещает их в корневой папке sql
     * @throws FileImportException исключение для случай сбоя импорта
     */
    public function importData(): void
    {
        if (!is_dir('sql')) {
            mkdir('sql');
        }

        if (!$this->validateColumns($this->columns)) {
            throw new FileImportException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new FileImportException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);

        } catch (FileImportException $exception) {
            throw new FileImportException("Не удалось открыть файл на чтение");
        }

        $this->getHeaderData();

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

        $this->sqlExport();
    }

    protected function getData(): array
    {
        return array_filter($this->result, function ($item) {
            if (count($item) > 1) {
                return !empty($item);
            }
            return null;
        });
    }

    protected function getHeaderData(): ?array
    {
        $this->fileObject->rewind();
        return $this->fileObject->fgetcsv();
    }

    protected function getNextLine(): ?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }


    protected function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }

    abstract protected function sqlExport(): void;
}
