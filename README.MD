
# Installation

make sure your php version > 7.0

```bash
composer require viloveul/console
```

## HOW

```php
require __DIR__ . '/vendor/autoload.php';

class MyCommand extends Viloveul\Console\Command
{
    protected static $defaultName = 'hello';

    public function handle()
    {
        $this->output->writeLn('Hello World');
    }
}

$console = new Viloveul\Console\Console();
$console->boot();

// add command
$console->add(new MyCommand);

// run
$console->run();
```

then

```bash
$ php your-file hello
```