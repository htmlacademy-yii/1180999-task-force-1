<?php

namespace frontend\services;

use frontend\models\Files;
use frontend\models\forms\TaskCreateForm;
use frontend\models\Tasks;
use frontend\models\TasksFiles;
use taskforce\Task;
use Yii;
use yii\web\UploadedFile;

class TaskCreateService
{
    private TaskCreateForm $form;

    /**
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
        $task->dt_add = date('Y-m-d');
        $task->user_id = Yii::$app->user->id;
        $task->category_id = $this->form->category;
        $task->name = $this->form->name;
        $task->description = $this->form->description;
        $task->cost = $this->form->cost;
        $task->deadline = $this->form->deadline;
        $task->location = 1;
        $task->status = Task::STATUS_NEW;
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
     * @param Tasks $task
     */
    private function uploadFiles(Tasks $task)
    {
        $this->form->files = UploadedFile::getInstances($this->form, 'files');

        if ($this->form->uploadFiles()) {

            $taskFiles = $this->form->uploadFiles();
            foreach ($taskFiles as $files) {
                foreach ($files as $name => $path) {

                    $files = new Files();
                    $files->name = $name;
                    $files->path = $path;
                    $files->save();

                    $taskFiles = new TasksFiles();
                    $taskFiles->task_id = $task->id;
                    $taskFiles->file_id = $files->id;
                    $taskFiles->save();
                }
            }
        }
    }
}