<?php
    include 'MinesweeperConstant.php';
    include 'MinesweeperService.php';

    //Select mode
    $selectMode = mb_strtoupper(readline("Select mode: Easy or Normal :"));

    switch ($selectMode) {
        //case "EASY":
        //    $mode = EASY;
        //    break;
        case "NORMAL":
            $mode = NORMAL;
            break;
        default:
            $mode = EASY;
    }

    $minesweeperService = new MinesweeperService();
    $mines = $minesweeperService->mines;
    $minesCoordinate = $minesweeperService->minesCoordinateArr;
    $userInputArr = $minesweeperService->userInputArr;

    $minesCoordinate = $minesweeperService->decideMinesCoordinate($mines, $minesCoordinate, $mode);

    print_r($minesCoordinate);

    //User select position
    while(!in_array($userInputArr['selectCoordinate'], $minesCoordinate)) {
        //$userInputArr['selectCoordinateX'] = (int)readline("Enter Coordinate X:") - 1;
        //$userInputArr['selectCoordinateY'] = (int)readline("Enter Coordinate Y:") - 1;
        $userInputArr = $minesweeperService->userInputArr;

        $userInputArr = $minesweeperService->userSelectCoordinate($userInputArr, $mode);

        $numberOfMines =
            $minesweeperService->checkNumberOfMines($userInputArr, $minesCoordinate);

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