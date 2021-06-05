<?php


namespace taskforce\importer;


use JetBrains\PhpStorm\Pure;
use SplFileObject;
use Exception;
use taskforce\exceptions\FileImportException;

abstract class AbstractImporter
{
    protected string $importFile;
    protected array $columns;
    protected object $fileObject;

    protected array $data = [];

    /**
     * AbstractImporter constructor.
     * @param string $importFile путь к исходному файлу CSV
     * @param array $columns массив из полей таблицы
     */
    public function __construct(string $importFile, array $columns)
    {
        $this->importFile = $importFile;
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

        if (!file_exists($this->importFile)) {
            throw new FileImportException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->importFile);

        } catch (FileImportException $exception) {
            throw new FileImportException("Не удалось открыть файл на чтение");
        }

        $this->getHeaderData();

        foreach ($this->getNextLine() as $line) {
            $this->data[] = $line;
        }

        $this->exportFile();
    }

    /**
     * Фильтрует массив данных от пустых значения
     * @return array обработанный массив с данными
     */
    protected function getData(): array
    {
        return array_filter($this->data, function ($item) {
            if (count($item) > 1) {
                return !empty($item);
            }

            return null;
        });
    }

    /**
     * @return array|null возвращает заголовки данных
     */
    protected function getHeaderData(): ?array
    {
        $this->fileObject->rewind();
        return $this->fileObject->fgetcsv();
    }

    /**
     * Перебирает данные из файла
     * @return iterable|null
     */
    protected function getNextLine(): ?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
        var_dump($result);
        print gettype($result);
        return $result;
    }

    /**
     * Функция валидации переданных полей
     * @param array $columns массив с колонками
     * @return bool возвращает true в случае успеха
     */
    #[Pure] protected function validateColumns(array $columns): bool
    {
        if (!count($columns)) {
            return false;
        }

        foreach ($columns as $column) {
            if (!is_string($column)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Функция экспорта данными с предварительными форматированием под SQL-запросы
     * Проверяет существование экспортируемого файла, а так же доступ к записи
     * В случае успеха построчно записывает полученные данные в файл 'sql/*.sql'
     */
    abstract protected function exportFile(): void;
}
