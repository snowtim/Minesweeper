<?php
    include 'MinesweeperConstant.php';
    include 'MinesweeperService.php';

    //Select mode
    $selectMode = mb_strtoupper(readline("Select mode: Easy or Normal :"));

    switch ($selectMode) {
        case "EASY":
            $mode = EASY;
            break;
        case "NORMAL":
            $mode = NORMAL;
            break;
        default:
            $mode = EASY;
    }

    $minesweeperService = new MinesweeperService();

    $mines = $minesweeperService->mines;
    $minesCoordinate = $minesweeperService->minesCoordinate;

    $minesPosition = $minesweeperService->decideMinesCoordinate($mines, $minesCoordinate, $mode);

    print_r($minesPosition);

    //User select position
    $selectCoordinateX = readline("Enter Coordinate X:")-1;
    $selectCoordinateY = readline("Enter Coordinate Y:")-1;

    $selectPosition = $minesweeperService->userSelectPosition($selectCoordinateX, $selectCoordinateY, $mode);






    //echo $numberOfMines."\n";

    //print_r($mode);