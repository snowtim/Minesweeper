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
    $selectPosition = $minesweeperService->selectPosition;

    $minesPosition = $minesweeperService->decideMinesCoordinate($mines, $minesCoordinate, $mode);

    print_r($minesPosition);

    //User select position
    while(!in_array($selectPosition, $minesPosition)) {
        $selectCoordinateX = readline("Enter Coordinate X:") - 1;
        $selectCoordinateY = readline("Enter Coordinate Y:") - 1;

        $selectPosition = $minesweeperService->userSelectPosition($selectCoordinateX, $selectCoordinateY, $mode);

        $numberOfMines = $minesweeperService->checkNumberOfMines($selectPosition, $minesPosition, $selectCoordinateX, $selectCoordinateY);

        echo $numberOfMines . "\n";
    }

    //print_r($mode);