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
    $safeArea = $mode['range'][0] * $mode['range'][1] - $mode['mines'];

    //Initialization of object
    $minesweeperService = new MinesweeperService();
    $mines = $minesweeperService->mines;
    $allCoordinateAry = $minesweeperService->allCoordinateAry;
    $allCoordinateAry = $minesweeperService->generateAllCoordinatesBySelectMode($allCoordinateAry, $mode);
    $allCoordinateAry = $minesweeperService->decideMinesCoordinate($mines, $allCoordinateAry, $mode);

    //print_r($allCoordinateAry);

    //Start the game
    do {
        $targetCoordinateAry = $minesweeperService->targetCoordinateAry;
        $targetCoordinateAry = $minesweeperService->userSelectCoordinate($targetCoordinateAry, $mode);

        $gameOver = $minesweeperService->gameOver($targetCoordinateAry, $allCoordinateAry, $mode);
        if($gameOver == 1) {
            break;
        }

        $allCoordinateAry = $minesweeperService->checkoutSafeCoordinate($targetCoordinateAry, $allCoordinateAry, $mode);
        //print_r($allCoordinateAry);

        //print_r((array_keys(array_column($allCoordinateAry, 'safe_coordinate'),1)));

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