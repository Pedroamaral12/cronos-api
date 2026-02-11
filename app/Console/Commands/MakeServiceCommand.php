<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new service inside the app/Services directory.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceName = $this->argument('name');

        $dir = app_path('Services');
        $path = $dir . DIRECTORY_SEPARATOR . $serviceName . '.php';
        
       
         if (File::exists($path)) {
            $this->error("Service already exists: {$serviceName}");
            return self::FAILURE;
        }
 
        File::ensureDirectoryExists($dir);

        $namespace = 'App\\Services';
 
        File::put($path, "<?php\n\nnamespace {$namespace};\n\nclass {$serviceName}\n{\n    //\n}\n");
        
        $this->info("Service created successfully: {$serviceName}");
    }
}
