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
    $coordinateAry = $minesweeperService->generateAllCoordinatesBySelectMode($coordinateAry, $mode);
    $coordinateAry = $minesweeperService->decideMinesCoordinate($mines, $coordinateAry, $mode);

    //print_r($coordinateAry);

    //Start the game
    do {
        $userInputAry = $minesweeperService->userInputAry;
        $userInputAry = $minesweeperService->userSelectCoordinate($userInputAry, $mode);

        $gameOver = $minesweeperService->gameOver($userInputAry, $coordinateAry, $mode);
        if($gameOver == 1) {
            break;
        }

        $coordinateAry = $minesweeperService->checkoutSafeCoordinate($userInputAry, $coordinateAry, $mode);
        print_r($coordinateAry);

        print_r((array_keys(array_column($coordinateAry, 'safe_coordinate'),1)));

        $safeCoordinateAry = array_keys(array_column($coordinateAry, 'safe_coordinate'),1);

        foreach($safeCoordinateAry as $safeCoordinate) {
            $location = $coordinateAry[$safeCoordinate]['coordinate_X'].",".$coordinateAry[$safeCoordinate]['coordinate_Y'];

            switch($coordinateAry[$safeCoordinate]['mines_around']) {
                case 1:
                    echo sprintf("%d mine around %s.", $coordinateAry[$safeCoordinate]['mines_around'], $location) . "\n";
                    break;
                default :
                    echo sprintf("%d mines around %s.", $coordinateAry[$safeCoordinate]['mines_around'], $location) . "\n";
                    break;
            }
        }
    } while(count(array_keys(array_column($coordinateAry, 'safe_coordinate'),1)) != 40);