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
    $mines = $minesweeperService->mines;
    $minesCoordinateArr = $minesweeperService->minesCoordinateArr;
    $userInputArr = $minesweeperService->userInputArr;

    $minesCoordinateArr = $minesweeperService->decideMinesCoordinate($mines, $minesCoordinateArr, $mode);
    print_r($minesCoordinateArr);

    //Start the game
    while(!in_array($userInputArr['selectCoordinate'], $minesCoordinateArr)) {
        $userInputArr = $minesweeperService->userInputArr;

        $userInputArr = $minesweeperService->userSelectCoordinate($userInputArr, $mode);

        $numberOfMines =
            $minesweeperService->checkNumberOfMines($userInputArr, $minesCoordinateArr);

        if(isset($numberOfMines)) {
            switch ($numberOfMines) {
                case 0:
                    echo "No mines around your position.\n";
                    break;
                case 1:
                    echo "1 mine around your position.\n";
                    break;
                default:
                    echo $numberOfMines . " mines around your position.\n";
            }
        }
    }