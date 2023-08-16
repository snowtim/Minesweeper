<?php
    class MinesweeperService {
        public $mines;
        public $minesCoordinateArr;
        public $userInputArr;

        public function __construct() {
            $this->mines = 0;
            $this->minesCoordinateArr = array();
            $this->userInputArr['selectCoordinate'] = "";
            $this->userInputArr['selectCoordinateX'] = -1;
            $this->userInputArr['selectCoordinateY'] = -1;
        }

        //Decide where mines' position
        public function decideMinesCoordinate($mines, $minesCoordinateArr, $mode) {
            while($mines < $mode['mines']) {
                $minesCoordinateX = mt_rand(0, $mode['range'][0] - 1);
                $minesCoordinateY = mt_rand(0, $mode['range'][1] - 1);
                $minesTemporaryCoordinate = "$minesCoordinateX,$minesCoordinateY";

                if(!in_array($minesTemporaryCoordinate, $minesCoordinateArr)) {
                    $minesCoordinateArr[] = $minesTemporaryCoordinate;
                    $mines++;
                }
            }

            return $minesCoordinateArr;
        }

        //Composition of array that the position user select
        public function userSelectCoordinate($userInputArr, $mode) {
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
        }

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