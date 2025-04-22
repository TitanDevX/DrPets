<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class ServiceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--api} {--nc}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $serviceClassName = class_basename($name . 'Service');
        $serviceNamespace = 'App\\Services';
        $servicePath = app_path('Services\\' . $serviceClassName . '.php');
        $serviceFullNamespace = $serviceNamespace .'\\' . $serviceClassName;
        $serviceVarName = strtolower(substr($serviceClassName,0,1)) . substr($serviceClassName,1);
        $apiOp = $this->option('api');
        $controllerClassName = class_basename($name . 'Controller');
        if($apiOp){
            
            $controllerNamespace = 'App\\Http\\Controllers\\api';
            $controllerPath = app_path('Http\\Controllers\\api\\' . $controllerClassName . '.php');
        }else{
            $controllerNamespace = 'App\\Http\\Controllers';
            $controllerPath = app_path('Http\\Controllers\\' . $controllerClassName . '.php');
        }
        
        $controllerStub = "<?php

namespace {$controllerNamespace};
use App\Http\Controllers\Controller;
use {$serviceFullNamespace};
class {$controllerClassName} extends Controller
{
    public function __construct(protected {$serviceClassName} \${$serviceVarName}){}
}";

        $serviceStub = "<?php

namespace {$serviceNamespace};


class {$serviceClassName}
{

}";
        File::ensureDirectoryExists(dirname($controllerPath));
        File::ensureDirectoryExists(dirname($servicePath));
        File::put($servicePath, $serviceStub);
        
       
        $this->components->info("<fg=white>Service <options=bold>[{$this->relativePath($servicePath)}]</> created successfully</>.");
        if(!$this->option('nc')){
            File::put($controllerPath, $controllerStub);
            $this->components->info("<fg=white>Controller <options=bold>[{$this->relativePath($controllerPath)}]</> created successfully</>.");
        }
    }
  

    protected function relativePath(string $path)
{
    return str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path);
}
}
