<?php
    class MinesweeperService {
        public $mines;
        public $coordinateArr;

        public function __construct() {
            $this->mines = 0;
            $this->coordinateArr = array();
            $this->userInputArr['selectCoordinate'] = "";
            $this->userInputArr['selectCoordinateX'] = -1;
            $this->userInputArr['selectCoordinateY'] = -1;
        }

        //Generate coordinate
        public function generateAllCoordinatesBySelectMode($coordinateArr, $mode) {
            for($coordinateX = 0; $coordinateX < $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 0; $coordinateY < $mode['range'][1]; $coordinateY++) {
                    $coordinateArr[$coordinateX][$coordinateY] = [
                        'mine' => 0,
                        'checked' => 0
                    ];
                }
            }

            return $coordinateArr;
        }

        //Decide where mines' position
        public function decideMinesCoordinate($mines, $coordinateArr, $mode) {
            while($mines < $mode['mines']) {
                $coordinateX = mt_rand(0, $mode['range'][0] - 1);
                $coordinateY = mt_rand(0, $mode['range'][1] - 1);
                $coordinateArr[$coordinateX][$coordinateY]['mine'] = 1;

                $mines++;
            }

            return $coordinateArr;
        }

        //Composition of array that the position user select
        /*public function userSelectCoordinate($userInputArr, $mode) {
            while(($userInputArr['selectCoordinateX'] > $mode['range'][0] - 1) || $userInputArr['selectCoordinateX'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputArr['selectCoordinateX'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($userInputArr['selectCoordinateY'] > $mode['range'][1] - 1) || $userInputArr['selectCoordinateY'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputArr['selectCoordinateY'] = (int)readline("Enter Coordinate Y:")-1;
            }

            $userInputArr['selectCoordinate'] = $userInputArr['selectCoordinateX'].",".$userInputArr['selectCoordinateY'];

            return $userInputArr;
        }*/

        //check number of mines around the position user select
        public function checkNumberOfMines ($userInputArr, $minesCoordinate) {
            if(in_array($userInputArr['selectCoordinate'], $minesCoordinate)) {
                echo "You Died"."\n";
                return;
            }

            $numberOfMines = 0;

            foreach ($minesCoordinate as $coordinates) {
                $coordinatesX = explode(",", $coordinates)[0];
                $coordinatesY = explode(",", $coordinates)[1];

                //calculate distance between mines and the position user select
                $squareOfDistance =
                    pow($userInputArr['selectCoordinateX'] - $coordinatesX, 2) +
                    pow($userInputArr['selectCoordinateY'] - $coordinatesY, 2);
                if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                    $numberOfMines++;
                }
            }

            return $numberOfMines;
        }
    }