<?php
namespace AppLogger\AppLogger\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Logger;
use Laminas\Log\Formatter\Simple;
use Laminas\Log\Filter\Priority;

class AppLogger implements FactoryInterface
{
    private $logger;

    public function getLogger()
    {
        return $this->logger;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $config = $config['AppLogger'];
        $this->logger = new Logger();

        $this->configuration($config);
        $this->writerCollection($config);
        $this->execute();

        return $this->logger;
    }

    private function writerCollection(array $config)
    {
        if (! empty($config['writers'])) {
            $writers = 0;
            foreach ($config['writers'] as $writer) {
                if ($writer['enabled']) {
                    $this->writerAdapter($writer);
                    $writers ++;
                }
            }

            return $writers;
        }
    }

    private function writerAdapter(array $writer)
    {
        $file = getcwd() . '/data/logs/' . date('Ymd') . '.log';

        if (! file_exists($file)) {
            umask(0000);
            fopen($file, 'w');
        }

        $writerAdapter = new Stream($file);
        $this->logger->addWriter($writerAdapter);
        $format = '%timestamp% ' . (isset($_SERVER['HTTP_REQUEST_ID']) ? $_SERVER['HTTP_REQUEST_ID'] . ' ' : 'HTTP_REQUEST_ID ') . session_id() 
                                 . ' - ' . (! empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] . ' - ' : 'CLI - ') 
                                 . (! empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] . ' - ' : 'IP UNAVAILABLE - ') 
                                 . ' %priorityName% (%priority%): %message% %extra%';
        $formatter = new Simple($format);
        $writerAdapter->setFormatter($formatter);
        $writerAdapter->addFilter(new Priority($writer['filter']));

        return $writerAdapter;
    }

    private function configuration(array $config)
    {
        if (! empty($config['registerErrorHandler'])) {
            $config['registerErrorHandler'] === false ?: AppLogger::registerErrorHandler($this->logger);
        }
        if (! empty($config['registerExceptionHandler'])) {
            $config['registerExceptionHandler'] === false ?: AppLogger::registerExceptionHandler($this->logger);
        }
    }

    private function execute()
    {
        if ($this->logger->getWriters()->count() == 0) {
            return $this->logger->addWriter(new \Laminas\Log\Writer\Null());
        }
    }
}