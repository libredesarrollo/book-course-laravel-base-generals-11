<?php 
namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class CustomLogging {
    public function __invoke($logger){
        foreach($logger->getHandlers() as $handle){
            $handle->setFormatter(new LineFormatter("[%datetime%] -- %channel%.%level_name%: %message% %context% %extra%\n"), null, true, true);
        }
    }
}