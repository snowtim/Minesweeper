<?php
    namespace Minesweeper;

    require_once 'MinesweeperConstant.php';
    require_once 'MinesweeperService.php';

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
    $minesCoordinateAry = $minesweeperService->minesCoordinateAry;
    $checkedCoordinateAry = $minesweeperService->checkedCoordinateAry;

    $minesCoordinateAry = $minesweeperService->decideMinesCoordinate($minesCoordinateAry, $mode);

    print_r($minesCoordinateAry);

    //Start the game
    do {
        $userInputAry = $minesweeperService->userInputAry;
        $userInputAry = $minesweeperService->userSelectCoordinate($userInputAry, $mode);
        $numberOfMines =
            $minesweeperService->checkNumberOfMines($userInputAry, $minesCoordinateAry);

        if(isset($numberOfMines)) {
            //just practice

            //$numberOfMines = 1 ? sprintf("%d mine around your position.\n", $numberOfMines) : sprintf("%d mines around your position.\n", $numberOfMines);
            switch ($numberOfMines) {
                case 1:
                    echo sprintf("%d mine around your position.\n", $numberOfMines);
                    break;
                default:
                    echo sprintf("%d mines around your position.\n", $numberOfMines);
            }
        }

        $checkedCoordinateAry =
            $minesweeperService->safeArea($userInputAry, $minesCoordinateAry, $checkedCoordinateAry, $mode);

        $safeCoordinate = $mode['range'][0]*$mode['range'][1] - $mode['mines'];

        if(count($checkedCoordinateAry) == $safeCoordinate) {
            echo "You Win!!\n";
        }

        sort($checkedCoordinateAry);
        print_r($checkedCoordinateAry);

    } while (!in_array($userInputAry['selectCoordinate'], $minesCoordinateAry) && count($checkedCoordinateAry) != $safeCoordinate);


