<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new repository in app/Repositories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $repositoryName = $this->argument('name');

        $dir = app_path('Repositories');
        $path = $dir . DIRECTORY_SEPARATOR . $repositoryName . '.php';
        
       
         if (File::exists($path)) {
            $this->error("Service already exists: {$repositoryName}");
            return self::FAILURE;
        }
 
        File::ensureDirectoryExists($dir);

        $namespace = 'App\\Repositories';
 
        File::put($path, "<?php\n\nnamespace {$namespace};\n\nclass {$repositoryName}\n{\n    //\n}\n");
        
        $this->info("Repository created successfully: {$repositoryName}");
    }
}
