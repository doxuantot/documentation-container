<?php

namespace App\Containers\Vendor\Documentation\Tasks;

use App\Containers\Vendor\Documentation\Traits\DocsGeneratorTrait;
use App\Ship\Parents\Tasks\Task as AbstractTask;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GenerateAPIDocsTask extends AbstractTask
{
    use DocsGeneratorTrait;

    public function run($type, $console): string
    {
        $path = $this->getDocumentationPath($type);

        $executableArgs = config('vendor-documentation.executable_args', []);

        $command = array_merge(
            [$this->getExecutable()],
            $executableArgs,
            [
                "-c",
                $this->getJsonFilePath($type),
            ],
            $this->getEndpointFiles($type),
            [
                "-i",
                "app",
                "-o",
                $path,
                "--single",
            ]
        );

        $process = new Process($command);

        // execute the command
        $process->run();

        if (!$process->isSuccessful()) {
            $console->error('Error Output: ' . $process->getOutput());
            throw new ProcessFailedException($process);
        }

        // echo the output
        $console->info('[' . $type . '] ' . implode(' ', $command));
        $console->info('Output: ' . $process->getOutput());

        // return the path to the generated documentation
        return $this->getFullDocsUrl($type);
    }
}
