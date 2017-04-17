<?php

namespace MHDev\Calendar\Model;

use Pagekit\System\Model\DataModelTrait;
use Pagekit\Database\ORM\ModelTrait;
use Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@calendar_events")
 */
class Event implements \JsonSerializable
{

    use ModelTrait, DataModelTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column */
    public $title = '';

    /** @Column(type="datetime") */
    public $start;
	
	/** @Column(type="datetime") */
    public $end;

    /** @Column(type="text") */
    public $description = '';
	
	/** @Column(type="boolean") */
	public $allDay;
	
	/** @Column(type="integer") */
	public $category_id;
	
	/**
     * @BelongsTo(targetEntity="MHDev\Calendar\Model\Category", keyFrom="category_id")
     */
    public $category;
	
    /** @Column(type="integer") */
    public $author_id;

    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="author_id")
     */
    public $author;
	
	/**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
		$color = null;
		if ($this->category_id)
		$color = Category::find($this->category_id)->color;
		
		$undefinedEnd = $this->start == $this->end;
		
        return $this->toArray(['color' => $color, 'author' => User::find($this->author_id), 'undefinedEnd' => $undefinedEnd]);
    }
}