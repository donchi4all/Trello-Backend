<?php


namespace App\Services;


use App\Models\Board;

class ListService implements \App\Contracts\ListServiceInterface
{


    /**
     * @inheritDoc
     */
    public function show(Board  $board, int $listId)
    {
        return  $board->lists()->findOrFail($listId);
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload, $board)
    {
        return $board->lists()->create($payload);
    }

    /**
     * @inheritDoc
     */
    public function update( array $payload,  Board $board, $listId )
    {
        $list = $board->lists()->findOrFail($listId);
        $list->update( $payload );
        return $list;
    }

    /**
     * @inheritDoc
     */
    public function delete( Board $board , int $listId)
    {
        $list = $board->lists()->findOrFail($listId);
        $list->delete();
        return $list;
    }
}
