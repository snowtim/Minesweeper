<?php
    include 'MinesweeperConstant.php';
    include 'MinesweeperService.php';

    //Select mode
    $selectMode = mb_strtoupper(readline("Select mode: Easy or Normal :"));

    switch ($selectMode) {
        case "NORMAL":
            $mode = NORMAL;
            break;
        default:
            $mode = EASY;
    }

    //Initialization of object
    $minesweeperService = new MinesweeperService();
    $allCoordinateAry = $minesweeperService->allCoordinateAry;
    $userInputAry = $minesweeperService->userInputAry;


    $allCoordinateAry = $minesweeperService->generateAllCoordinate($allCoordinateAry, $mode);
    $normalAndMinesCoordinateData = $minesweeperService->decideMinesCoordinate($allCoordinateAry, $mode);
    $allCoordinateAry = $normalAndMinesCoordinateData['all_coordinate_ary'];
    $minesCoordinateAry = $normalAndMinesCoordinateData['mines_coordinate_ary'];
    $allCoordinateAry =  $minesweeperService->accountNumberOfMinesAroundCenterCoordinate($allCoordinateAry, $minesCoordinateAry, $mode);

    //Start the game
    do{
        $userInputAry = $minesweeperService->userInputAry;
        $userInputAry = $minesweeperService->userSelectCoordinate($userInputAry, $mode);

        $gameOver = $minesweeperService->gameOver($userInputAry, $allCoordinateAry);
        if($gameOver == 0) {
            echo "Game Over!\n";
            break;
        }

        $allCoordinateAry = $minesweeperService->spreadSafeArea($userInputAry, $allCoordinateAry, $mode);
        $unopenedCoordinate = $minesweeperService->checkAllValueOfCoordinate($allCoordinateAry, $mode);
        echo $unopenedCoordinate;

    }while($unopenedCoordinate > 0);