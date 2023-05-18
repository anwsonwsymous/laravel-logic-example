<?php

namespace App\Services\Task\TaskDataGenerators;

/**
 * Class FakeFaceImageClassificationGenerator
 * @package App\Services\Task\TaskDataGenerators
 */
class FakeFaceImageClassificationGenerator extends BasicImageClassificationDataGenerator
{

    /**
     * @inheritDoc
     */
    protected function datasetName(): string
    {
        return 'fake_face_image_classification';
    }
}
