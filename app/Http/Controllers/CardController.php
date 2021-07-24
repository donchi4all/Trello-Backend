<?php

namespace App\Http\Controllers;

use App\Contracts\BoardServiceInterface as BoardService;
use App\Contracts\CardServiceInterface as CardService;
use App\Contracts\ListServiceInterface as ListService;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
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
     * @var CardService
     */
    private $cardService;


    /**
     * ListController constructor.
     */
    public function __construct(ListService $listService , BoardService $boardService, CardService $cardService )
    {
        $this->listService = $listService;
        $this->boardService = $boardService;
        $this->cardService = $cardService;
    }

    public function index( int $boardId, int $listId )
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');
        $cards = $this->cardService->index( $board, $listId );

        return success('Card successfully loaded', $cards);
    }


    public function create( Request  $request , int $boardId, int $listId)
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->show($board, $listId);
        $card = $this->cardService->create($request->all(), $list);
        return success('Card successfully loaded', $card);
    }


    public function show(int $boardId, int $listId, int $cardId)
    {
        $board = $this->boardService->show( $boardId );

        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->show( $board, $listId );
        $card = $this->cardService->show( $list,$cardId );
        return success('Card successfully loaded', $card);
    }


    public function update(Request $request, int  $boardId , int $listId, int $cardId)
    {

        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->show( $board, $listId );

        $card = $this->cardService->update($request->all(), $list,$cardId );

        if ( ! $card  ) return dbError('Error Saving to db');

        return success('Card successfully updated', $card);
    }


    public function destroy(int $boardId, int $listId, int  $cardId )
    {
        $board = $this->boardService->show( $boardId );
        if( $board && $board->user_id !== auth()->user()->id)
            return  unAuthorized('You are not permitted to access this route');

        $list = $this->listService->show( $board, $listId );

        $card = $this->cardService->delete( $list, $cardId);

        return success('Card successfully deleted', $card);
    }
}
