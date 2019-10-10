<?php
namespace News\CommandHandler\News;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;
use Marmot\Framework\Classes\NullCommandHandler;
use Marmot\Interfaces\ICommandHandlerFactory;

class NewsCommandHandlerFactory implements ICommandHandlerFactory
{
    const MAPS = array(
        'News\Command\News\AddNewsCommand'=>'News\CommandHandler\News\AddNewsCommandHandler',
        'News\Command\News\EditNewsCommand'=>'News\CommandHandler\News\EditNewsCommandHandler',
        'News\Command\News\DisableNewsCommand'=>'News\CommandHandler\News\DisableNewsCommandHandler',
        'News\Command\News\EnableNewsCommand'=>'News\CommandHandler\News\EnableNewsCommandHandler',
    );

    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandClass = get_class($command);
        $commandHandler = isset(self::MAPS[$commandClass]) ? self::MAPS[$commandClass] : '';

        return class_exists($commandHandler) ? new $commandHandler : new NullCommandHandler();
    }
}
