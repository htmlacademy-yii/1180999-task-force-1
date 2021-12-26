<?php

namespace frontend\services;

use frontend\models\Files;

class FileUploadService
{
    /**
     * @param $uploadFile
     * @return int
     */
    public function upload($uploadFile): int
    {
        $file = new Files();
        $fileName = uniqid();
        $file->name = "$uploadFile->baseName.$uploadFile->extension";
        $file->path = '/uploads/' . $fileName . '.' . $uploadFile->extension;
        $file->save();
        $uploadFile->saveAs("uploads/$fileName.$uploadFile->extension");

        return $file->id;
    }
}