<?php

namespace Bin\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DummyCommand extends Command
{

	protected function configure()
	{
		// $this->setName('szif:articles')
			// ->setDescription('Downloads articles from SZIF API and stores them in DB.');
	}


	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('Fetching from remote');
	}

}
