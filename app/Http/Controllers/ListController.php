<?php

namespace App\Http\Controllers;

use App\Contracts\BoardServiceInterface as BoardService;
use App\Contracts\ListServiceInterface as ListService;
use Illuminate\Http\Request;

/**
 * Class ListController
 * @package App\Http\Controllers
 */
class ListController extends Controller
{
    /**
     * @var ListService
     */
    private $listService;
    /**
     * @var BoardService
     */
    private $boardService;


    /**
     * ListController constructor.
     */
    public function __construct(ListService $listService , BoardService $boardService )
    {
        $this->listService = $listService;
        $this->boardService = $boardService;
    }

    public function index( int $boardId )
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $board->lists()->with('cards')->get();
        return success('List successfully loaded', $list);
    }


    public function create( Request  $request , int $boardId)
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->create($request->all(), $board);
        return success('List successfully loaded', $list);
    }


    public function show(int $boardId, int $listId)
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->show($board, $listId);

        return success('List successfully loaded', $list);
    }


    public function update(Request $request, int  $boardId , int $listId)
    {

        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->update($request->all(), $board, $listId );

        if ( ! $list  ) return dbError('Error Saving to db');

        return success('List successfully updated', $list);
    }


    public function destroy(int $boardId, int $listId )
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->delete( $board, $listId);
        return success('List successfully deleted', $list);
    }
}
