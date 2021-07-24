<?php


namespace App\Contracts;


use App\Models\Board;

interface BoardServiceInterface
{
    /**
     * @return mixed
     */
    public function index();


    /**
     * @param int $boardId
     * @return mixed
     */
    public function show(int $boardId);

    /**
     * @param array $payload
     * @return mixed
     */
    public function create(array $payload);

    /**
     * @param array $payload
     * @return mixed
     */
    public function update(array $payload, int $boardId);

    /**
     * @param int $boardId
     * @return mixed
     */
    public function delete(int $boardId);
}
