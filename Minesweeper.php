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
    $coordinateAry = $minesweeperService->coordinateAry;
    $userInputAry = $minesweeperService->userInputAry;

    $coordinateAry = $minesweeperService->generateAllCoordinatesBySelectMode($coordinateAry, $mode);

    $coordinateAry = $minesweeperService->decideMinesCoordinate($mines, $coordinateAry, $mode);
    print_r($coordinateAry);

    $col = array_values($coordinateAry);

    print_r($col);

    //Start the game
    /*do {
        $userInputAry = $minesweeperService->userInputAry;

        $userInputAry = $minesweeperService->userSelectCoordinate($userInputAry, $mode);

        $numberOfMines =
            $minesweeperService->checkNumberOfMines($userInputAry, $coordinateAry);

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
    } while(($coordinateArr[$userInputCoordinateX][$userInputCoordinateY]['mine'] !== 0));*/