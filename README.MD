
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
    public function handle()
    {
        $this->writeNormal('Hello World');
        $this->writeInfo('Hello World');
        $this->writeError('Hello World');
        $this->writeQuestion('Hello World');
        $this->writeComment('Hello World');
    }
}

$console = new Viloveul\Console\Console();
$console->boot();

// add command
$cmd = new MyCommand("hello");
$console->add($cmd);

// run
$console->run();
```

then

```bash
$ php your-file hello
```