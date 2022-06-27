<?php

namespace Maid\Sdk\Support;

use Maid\Sdk\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
class Paginator
{
    private ?string $nextCursor;

    private ?string $prevCursor;

    /**
     * Next desired action (first, after, before).
     *
     * @var string|null
     */
    public ?string $action = null;

    /**
     * Constructor.
     *
     * @param string|null $nextCursor
     * @param string|null $prevCursor
     */
    public function __construct(string $nextCursor = null, string $prevCursor = null)
    {
        $this->nextCursor = $nextCursor;
        $this->prevCursor = $prevCursor;
    }

    /**
     * Create Paginator from Result object.
     *
     * @param Result $result Result object
     *
     * @return Paginator|null Paginator object
     */
    public static function from(Result $result): ?self
    {
        if ($result->prev_cursor || $result->next_cursor) {
            return new self($result->next_cursor, $result->prev_cursor);
        }

        return null;
    }

    /**
     * Return the current active cursor.
     *
     * @return string Maid cursor
     */
    public function cursor(): string
    {
        if ($this->action == 'after') {
            return $this->nextCursor;
        } else {
            return $this->prevCursor;
        }
    }

    /**
     * Set the Paginator to fetch the first set of results.
     *
     * @return Paginator|null
     */
    public function next(): ?self
    {
        if (!$this->nextCursor) {
            return null;
        }

        $this->action = 'after';

        return $this;
    }

    /**
     * Set the Paginator to fetch the last set of results.
     *
     * @return Paginator|null
     */
    public function back(): ?self
    {
        if (!$this->prevCursor) {
            return null;
        }

        $this->action = 'before';

        return $this;
    }
}
