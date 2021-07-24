<?php

namespace App\Http\Controllers;

use App\Contracts\BoardServiceInterface as BoardService;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * @var BoardService
     */
    private $boardService;


    /**
     * BoardController constructor.
     */
    public function __construct( BoardService $boardService )
    {
        $this->boardService = $boardService;
    }

    public function index()
    {
        $board = $this->boardService->index();
        return success('Board successfully loaded', $board);
    }


    public function create( Request  $request )
    {
        $board = $this->boardService->create($request->all());
        return success('Board successfully loaded', $board);
    }


    public function show(int $boardId)
    {
        $board = $this->boardService->show($boardId);
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        return success('Board successfully loaded', $board);
    }


    public function update(Request $request, int  $boardId )
    {
        $board = $this->boardService->show( $boardId );

        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

       $upatedBoard = $this->boardService->update($request->all() , $boardId);

        if ( ! $upatedBoard ) return dbError('Error Saving to db');
        return success('Board successfully updated', $board);
    }


    public function destroy( $boardId )
    {
        $board = $this->boardService->delete( $boardId );
        return success('Board successfully deleted', $board);
    }
}
