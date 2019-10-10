<?php
namespace News\Command\News;

use Marmot\Interfaces\ICommand;

class AddNewsCommand implements ICommand
{
    public $title;

    public $source;

    public $content;

    public $image;

    public $attachments;

    public $publishUserGroup;

    public $id;

    public function __construct(
        string $title,
        string $source,
        string $content,
        array $image,
        array $attachments = array(),
        int $publishUserGroup = 0,
        int $id = 0
    ) {
        $this->title = $title;
        $this->source = $source;
        $this->content = $content;
        $this->image = $image;
        $this->attachments = $attachments;
        $this->publishUserGroup = $publishUserGroup;
        $this->id = $id;
    }
}
