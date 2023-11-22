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
    //Total number of safe area.
    $safeArea = $mode['range'][0] * $mode['range'][1] - $mode['mines'];

    //Initialization of MinesweeperService.
    $minesweeperService = new MinesweeperService();
    $allCoordinateAry = $minesweeperService->allCoordinateAry;
    $allCoordinateAry = $minesweeperService->generateAllCoordinatesBySelectMode($allCoordinateAry, $mode);
    $allCoordinateAry = $minesweeperService->decideMinesCoordinate($allCoordinateAry, $mode);

    //Start the game
    do {
        //User select and input coordinate.
        $targetCoordinateAry = $minesweeperService->targetCoordinateAry;
        $targetCoordinateAry = $minesweeperService->userSelectCoordinate($targetCoordinateAry, $mode);

        //If the coordinate has mine, finish game.
        $gameOver = $minesweeperService->gameOver($targetCoordinateAry, $allCoordinateAry, $mode);
        if($gameOver == 1) {
            break;
        }


        $allCoordinateAry = $minesweeperService->checkoutSafeCoordinate($targetCoordinateAry, $allCoordinateAry, $mode);
        //print_r($allCoordinateAry);

        //Sort out key of safe coordinate.
        $safeCoordinateAry = array_keys(array_column($allCoordinateAry, 'safe_coordinate'),1);

        foreach($safeCoordinateAry as $safeCoordinate) {
            $coordinate = ($allCoordinateAry[$safeCoordinate]['coordinate_X']+1).",".($allCoordinateAry[$safeCoordinate]['coordinate_Y']+1);

            switch($allCoordinateAry[$safeCoordinate]['mines_around']) {
                case 1:
                    echo sprintf("%d mine around %s.", $allCoordinateAry[$safeCoordinate]['mines_around'], $coordinate) . "\n";
                    break;
                default :
                    echo sprintf("%d mines around %s.", $allCoordinateAry[$safeCoordinate]['mines_around'], $coordinate) . "\n";
                    break;
            }
        }
    } while(count($safeCoordinateAry) != $safeArea);