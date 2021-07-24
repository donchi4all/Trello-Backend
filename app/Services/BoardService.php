<?php


namespace App\Services;


use App\Models\Board;

class BoardService implements \App\Contracts\BoardServiceInterface
{
    /**
     * @var Board
     */
    private $model;

    /**
     * BoardService constructor.
     */
    public function __construct( Board $board )
    {
        $this->model = $board;
    }


    /**
     * @inheritDoc
     */
    public function index()
    {
        return auth()->user()->boards()->get();
    }

    /**
     * @inheritDoc
     */
    public function show( int $boardId )
    {
        return $this->model->findOrFail($boardId);
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload)
    {
        return auth()->user()->boards()->create(
            $payload
        );
    }

    /**
     * @inheritDoc
     */
    public function update(array $payload, int $boardId)
    {
        $board = auth()->user()->boards()->whereId($boardId)
            ->update($payload);
        return ['update' => $board];
    }

    /**
     * @inheritDoc
     */
    public function delete(int $boardId)
    {
        $board =  $this->show($boardId);
        $board->delete();
       return $board;
    }
}
