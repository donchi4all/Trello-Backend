<?php


namespace App\Contracts;


use App\Models\Board;

interface ListServiceInterface
{


    /**
     * @param int $listId
     * @return mixed
     */
    public function show(Board  $board, int $listId);


    /**
     * @param array $payload
     * @param Board $board
     * @return mixed
     */
    public function create(array $payload, Board $board);


    /**
     * @param int $listId
     * @param array $payload
     * @return mixed
     */
    public function update( array $payload,  Board $board , $listId);

    /**
     * @param int $listId
     * @return mixed
     */
    public function delete( Board $board , int $listId);
}
