<?php

namespace App\Services\Task\TaskDataGenerators;

use Intervention\Image\Facades\Image;

/**
 * Class FruitImageClassificationGenerator
 * @package App\Services\Task\TaskDataGenerators
 */
class FruitImageClassificationGenerator extends BasicImageClassificationDataGenerator
{

    /**
     * Some images in dataset are corrupted, so we check its height/width before returning
     *
     * @return array
     */
    public function generate(): array
    {
        $data = parent::generate();

        $image = Image::make($data['image']);
        // Height is 3 times less than width (there are corrupted images in this dataset)
        if ($image->height() < $image->width() / 3) {
            return $this->generate();
        }
        // Too narrow
        if ($image->width() < 150) {
            return $this->generate();
        }
        // Height is two times bigger than width
        if ($image->width() * 2 <= $image->height()) {
            return $this->generate();
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    protected function datasetName(): string
    {
        return 'fruit_image_classification';
    }
}
