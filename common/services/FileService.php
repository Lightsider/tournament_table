<?php


namespace common\services;


use http\Exception\RuntimeException;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class FileService
{
    public const PATH_PREFIX = '@frontend/web/uploads/';

    /**
     * Generate random filename
     * @param string $ext file extension
     * @return string
     */
    public function generateFileName(string $ext): string
    {
        try {
            return implode('', [
                static::PATH_PREFIX,
                Yii::$app->security->generateRandomString(),
                '.',
                $ext,
            ]);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $filePath
     * @param UploadedFile $uploadedFile
     * @return bool
     */
    public function upload(string $filePath, UploadedFile $uploadedFile): bool
    {
        return $uploadedFile->saveAs($filePath);
    }
}