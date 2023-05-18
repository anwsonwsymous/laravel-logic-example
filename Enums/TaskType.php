<?php

namespace App\Enums;

use App\Services\Task\Contracts\TaskDataGenerator;
use App\Services\Task\Contracts\TaskResultHandler;
use App\Services\Task\TaskDataGenerators\FakeFaceImageClassificationGenerator;
use App\Services\Task\TaskDataGenerators\FruitImageClassificationGenerator;
use App\Services\Task\TaskResultHandlers\FakeFaceImageClassificationHandler;
use App\Services\Task\TaskResultHandlers\FruitImageClassificationHandler;

/**
 * Enum TaskType
 * @package App\Enums
 */
enum TaskType: int
{
    case FAKE_FACE_IMAGE_CLASSIFICATION = 1;
    case FRUIT_IMAGE_CLASSIFICATION = 2;

    public static function random(): self
    {
        return self::cases()[rand(0, count(self::cases()) - 1)];
    }

    public function toGenerator(): TaskDataGenerator
    {
        return match ($this) {
            self::FAKE_FACE_IMAGE_CLASSIFICATION => app(FakeFaceImageClassificationGenerator::class),
            self::FRUIT_IMAGE_CLASSIFICATION => app(FruitImageClassificationGenerator::class),
        };
    }

    public function toHandler(): TaskResultHandler
    {
        return match ($this) {
            self::FAKE_FACE_IMAGE_CLASSIFICATION => app(FakeFaceImageClassificationHandler::class),
            self::FRUIT_IMAGE_CLASSIFICATION => app(FruitImageClassificationHandler::class),
        };
    }
}
