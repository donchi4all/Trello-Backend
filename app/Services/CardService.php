<?php


namespace App\Services;


use App\Models\Board;
use App\Models\Category;

class CardService implements \App\Contracts\CardServiceInterface
{

    /**
     * @inheritDoc
     */
    public function show(Category $list, int $cardId)
    {
        return  $list->cards()->findOrFail($cardId);
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload, Category $list)
    {
        return $list->cards()->create($payload);
    }

    /**
     * @inheritDoc
     */
    public function update( array $payload, Category $list, $cardId )
    {
        $card = $list->cards()->findOrFail( $cardId );
        $card->update( $payload );
        return $card;
    }

    /**
     * @inheritDoc
     */
    public function delete( Category $list , int $cardId)
    {
        $card = $list->cards()->findOrFail($cardId);
        $card->delete();
        return $card;
    }

    public function index(Board $board, $listId)
    {
        $list = $board->lists()->findOrFail($listId);
        return $list->cards;
    }
}
