<?php

namespace backend\models\forms;

use common\models\Team;
use http\Exception\RuntimeException;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Team form
 *
 * @property int $id
 * @property string $name
 * @property int|null $score
 * @property string|null $image
 */
class TeamForm extends Model
{
    public $id;

    public $name;

    public $score;

    public $imageFile;

    public $image;

    private $fileService;

    public function __construct($config = [])
    {
        $this->fileService = Yii::$container->get('FileService');
        parent::__construct($config);
    }

    public function formName()
    {
        return 'TeamForm';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['score'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'score' => 'Score',
            'image' => 'Image',
        ];
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function save(int $id = 0): int
    {
        try {
            $model = $id === 0 ? new Team() : Team::findOne($id);

            $model->load($this->getAttributes(), '');
            if ($this->imageFile = UploadedFile::getInstance($this, 'image')) {
                $fileName = $this->fileService->generateFileName($this->imageFile->getExtension());
                if (!$this->fileService->upload($fileName, $this->imageFile)) {
                    throw new RuntimeException('Error with upload file');
                }
                $model->image = $fileName;
            }
            $model->save();
            $this->id = $model->id;

            return $model->id;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param Team $team
     * @return TeamForm
     */
    public static function fromModel(Team $team): TeamForm {
        $data = $team->getAttributes();
        $form = new self();
        $form->load($data, '');
        return $form;
    }
}
