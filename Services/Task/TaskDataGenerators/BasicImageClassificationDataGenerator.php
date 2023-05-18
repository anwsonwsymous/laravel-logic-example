<?php

namespace App\Services\Task\TaskDataGenerators;

use App\Services\Task\Contracts\TaskDataGenerator;
use Illuminate\Support\Facades\Storage;

/**
 * Class BasicImageClassificationDataGenerator
 * @package App\Services\Task\TaskDataGenerators
 */
abstract class BasicImageClassificationDataGenerator implements TaskDataGenerator
{

    /**
     * Dataset name, starting from storage tasks folder
     *
     * @return string
     */
    abstract protected function datasetName(): string;

    /**
     * Generate random image classification task
     *
     * @return array
     */
    public function generate(): array
    {
        // Get a list of all directories in the task storage folder
        $directories = Storage::directories(sprintf("tasks/%s", $this->datasetName()));

        // Pick a random directory (label) from the list
        $labelDirectory = $directories[array_rand($directories)];

        // Get a list of all files in the selected directory
        $files = Storage::files($labelDirectory);

        // Pick a random file from the list
        $randomFile = $files[array_rand($files)];

        // Get the full path to the random file
        $path = Storage::path($randomFile);
        // Get label from directory path
        $label = last(explode(DIRECTORY_SEPARATOR, $labelDirectory));
        // Get available labels from directory names
        $availableLabels = array_map(
            static fn ($path) => last(explode(DIRECTORY_SEPARATOR, $path)),
            $directories
        );

        // Create task data and return
        return [
            'image' => $path,
            'label' => $label,
            'available_labels' => $availableLabels
        ];
    }
}
