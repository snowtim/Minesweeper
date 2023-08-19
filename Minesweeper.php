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
    $minesCoordinateArr = $minesweeperService->minesCoordinateArr;
    $userInputArr = $minesweeperService->userInputArr;
    $checkedCoordinateArr = $minesweeperService->checkedCoordinateArr;

    $minesCoordinateArr = $minesweeperService->decideMinesCoordinate($minesCoordinateArr, $mode);

    print_r($minesCoordinateArr);

    //Start the game
    do {
        $userInputArr = $minesweeperService->userInputArr;
        $userInputArr = $minesweeperService->userSelectCoordinate($userInputArr, $mode);
        $numberOfMines =
            $minesweeperService->checkNumberOfMines($userInputArr, $minesCoordinateArr);

        if(isset($numberOfMines)) {
            switch ($numberOfMines) {
                case 1:
                    echo sprintf("%d mine around your position.\n", $numberOfMines);
                    break;
                default:
                    echo sprintf("%d mines around your position.\n", $numberOfMines);
            }
        }

        $checkedCoordinateArr =
            $minesweeperService->checkedArea($userInputArr, $minesCoordinateArr, $checkedCoordinateArr, $mode);

        $safeCoordinate = $mode['range'][0]*$mode['range'][1] - $mode['mines'];

        if(count($checkedCoordinateArr) == $safeCoordinate) {
            echo "You Win!!\n";
        }

        sort($checkedCoordinateArr);
        print_r($checkedCoordinateArr);

    } while (!in_array($userInputArr['selectCoordinate'], $minesCoordinateArr) && count($checkedCoordinateArr) != $safeCoordinate);


