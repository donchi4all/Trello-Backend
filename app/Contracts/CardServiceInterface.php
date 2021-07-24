<?php


namespace App\Contracts;


use App\Models\Board;
use App\Models\Category;

interface CardServiceInterface
{

    /**
     * @param Board $board
     * @param $listId
     * @return mixed
     */
    public function index(Board $board, $listId );
    /**
     * @param int $listId
     * @return mixed
     */
    public function show( Category $list, int $cardId);


    /**
     * @param array $payload
     * @param Category $list
     * @return mixed
     */
    public function create(array $payload, Category $list);


    /**
     * @param int $cardId
     * @param array $payload
     * @return mixed
     */
    public function update( array $payload,   Category $list, $cardId);

    /**
     * @param int $cardId
     * @return mixed
     */
    public function delete( Category $list, int $cardId);
}
