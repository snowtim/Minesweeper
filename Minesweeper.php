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

    //Decide where mines position
    /*$mines = 0;
    $minesCoordinate = array();

    while($mines < $mode['mines']) {
        $minesLocationX = mt_rand(0, $mode['range'][0] - 1);
        $minesLocationY = mt_rand(0, $mode['range'][1] - 1);

        if(empty($minesLocation[$minesLocationX][$minesLocationY])) {
            $minesLocation[$minesLocationX][$minesLocationY] = 1;
            echo $minesLocation[$minesLocationX][$minesLocationY];
        }

        $mines++;
    };
    while($mines < $mode['mines']) {
        $minesCoordinateX = mt_rand(0, $mode['range'][0] - 1);
        $minesCoordinateY = mt_rand(0, $mode['range'][1] - 1);
        $minesTemporaryCoordinate = "$minesCoordinateX,$minesCoordinateY";

        if(!in_array($minesTemporaryCoordinate, $minesCoordinate)) {
            $minesCoordinate[] = $minesTemporaryCoordinate;
            $mines++;
        }
    }*/
    $minesweeperService = new MinesweeperService();
    $mines = $minesweeperService->mines;
    $minesCoordinate = $minesweeperService->minesCoordinate;
    $minesPosition = $minesweeperService->decideMinesCoordinate($mines, $minesCoordinate, $mode);

    print_r($minesPosition);

    //User select position
    /*$selectCoordinateX = readline("Enter Coordinate X:")-1;
    while(($selectCoordinateX > $mode['range'][0] - 1) || $selectCoordinateX < 0) {
        echo "Invalid Coordinate, value must between 1~".$mode['range'][0]."\n";
        $selectCoordinateX = readline("Enter Coordinate X:")-1;
    }

    $selectCoordinateY = readline("Enter Coordinate Y:")-1;
    while(($selectCoordinateY > $mode['range'][1] - 1) || $selectCoordinateY < 0) {
        echo "Invalid Coordinate, value must between 1~".$mode['range'][1]."\n";
        $selectCoordinateY = readline("Enter Coordinate Y:")-1;
    }

    $selectCoordinate = "$selectCoordinateX,$selectCoordinateY";

    //
    if(in_array($selectCoordinate, $minesCoordinate)) {
        echo "You Died"."\n";
        return;
    }

    $numberOfMines = 0;
    foreach($minesCoordinate as $coordinates) {
        $coordinatesX = explode(",", $coordinates)[0];
        $coordinatesY = explode(",", $coordinates)[1];
        $squareOfDistance = pow($selectCoordinateX-$coordinatesX, 2) + pow($selectCoordinateY-$coordinatesY, 2);
        if($squareOfDistance==2 || $squareOfDistance==1) {
            $numberOfMines++;
        }
    }

    echo $numberOfMines."\n";*/

    //print_r($mode);