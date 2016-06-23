<?php

namespace Sukohi\Facet\Commands;

use Illuminate\Console\Command;

class FacetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facet {class} {namespace?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show accessor, mutator and scope';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$namespace = $this->argument('namespace');

		if(empty($namespace)) {

			$namespace = 'App';

		}

        $class = '\\'. $namespace .'\\'. $this->argument('class');

		if(!class_exists($class)) {

			$this->error('Class not exist.');

		} else {

			$methods = get_class_methods($class);
			$target_methods = [];

			foreach ($methods as $method) {

				if(preg_match('|^get(.+)Attribute$|', $method, $matches)) {

					$target_methods['accessors'][] = [
						'method' => $method,
						'attribute' => strtolower($matches[1])
					];

				} else if(preg_match('|^set(.+)Attribute$|', $method, $matches)) {

					$target_methods['mutators'][] = [
						'method' => $method,
						'attribute' => strtolower($matches[1])
					];

				} else if(preg_match('|^scope(.+)|', $method, $matches)) {

					$target_methods['scopes'][] = [
						'method' => $method,
						'attribute' => camel_case($matches[1])
					];

				}

			}

			if(empty($target_methods)) {

				$this->error('No accessor, mutator and scope.');
				die();

			}

			$dirties = [
				'accessors' => false,
				'mutators' => false,
				'scopes' => false
			];

			$class_instance = new $class;
			$reflect = new \ReflectionClass($class_instance);
			$argument =  '$'. strtolower($reflect->getShortName());

			foreach ($target_methods as $key => $data) {

				foreach ($data as $values) {

					if($key == 'accessors') {

						if(!$dirties['accessors']) {

							$dirties['accessors'] = true;
							$this->comment('Accessor');

						}

						$this->info(' '. $argument .'->'. $values['attribute']);

					} else if($key == 'mutators') {

						if(!$dirties['mutators']) {

							$dirties['mutators'] = true;
							$this->comment('Mutator');

						}

						$this->info(' '. $argument .'->'. $values['attribute'] .' = ');

					} else if($key == 'scopes') {

						if(!$dirties['scopes']) {

							$dirties['scopes'] = true;
							$this->comment('Scope');

						}

						$this->info(' '. $argument .'->'. $values['attribute'] .'()');

					}

				}

			}

		}

    }
}
