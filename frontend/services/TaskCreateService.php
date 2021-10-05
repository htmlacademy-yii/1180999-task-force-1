<?php

namespace frontend\services;

use frontend\models\Files;
use frontend\models\forms\TaskCreateForm;
use frontend\models\Tasks;
use frontend\models\TasksFiles;
use Yii;
use yii\web\UploadedFile;

class TaskCreateService
{
    private TaskCreateForm $form;

    /**
     * Создание новой задачи
     * @param array $data
     * @return int|null
     */
    public function execute(array $data): ?int
    {
        $this->form = new TaskCreateForm();
        if (!$this->form->load($data) || !$this->form->validate()) {
            return null;
        }

        $task = new Tasks();
        $task->user_id = Yii::$app->user->id;
        $task->category_id = $this->form->category;
        $task->name = $this->form->name;
        $task->description = $this->form->description;
        $task->cost = $this->form->cost;
        $task->deadline = $this->form->deadline;
        $task->save();

        $this->uploadFiles($task);
        return $task->id;
    }

    /**
     * @return TaskCreateForm
     */
    public function getForm(): TaskCreateForm
    {
        return $this->form;
    }

    /**
     * Сохраняет загруженные в форму файлы на сервер в директорию ~/web/uploads
     * Сохраняют информацию в БД: имя, путь и связь с задачей
     * Имена загруженных файлов генерируются автоматически
     * @param Tasks $task Данные формы создания задачи
     */
    private function uploadFiles(Tasks $task)
    {
        $uploadFiles = UploadedFile::getInstances($this->form, 'files');

        if (!empty($uploadFiles)) {

            foreach ($uploadFiles as $file) {

                $files = new Files();
                $fileName = uniqid();
                $files->name = "$file->baseName.$file->extension";
                $files->path = 'uploads/' . $fileName . '.' . $file->extension;
                $files->save();

                $file->saveAs("uploads/$fileName.$file->extension") ;

                $taskFiles = new TasksFiles();
                $taskFiles->task_id = $task->id;
                $taskFiles->file_id = $files->id;
                $taskFiles->save();
            }
        }
    }
}