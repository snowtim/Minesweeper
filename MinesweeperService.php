<?php
    namespace Minesweeper;

    class MinesweeperService {
        public $minesCoordinateAry;
        public $userInputAry;
        public $checkedCoordinateAry;

        public function __construct() {
            //$this->mines = 0;
            $this->minesCoordinateAry = array();
            $this->userInputAry = [
                'selectCoordinate' => "",
                'selectCoordinateX' => -1,
                'selectCoordinateY' => -1
                ];
            $this->checkedCoordinateAry = array();
        }

        //Decide where mines' position
        public function decideMinesCoordinate($minesCoordinateAry, $mode) {
            while($mode['mines'] > 0) {
                $minesCoordinateX = mt_rand(0, $mode['range'][0] - 1);
                $minesCoordinateY = mt_rand(0, $mode['range'][1] - 1);
                $minesTemporaryCoordinate = "$minesCoordinateX,$minesCoordinateY";

                if(!in_array($minesTemporaryCoordinate, $minesCoordinateAry)) {
                    $minesCoordinateAry[] = $minesTemporaryCoordinate;
                    $mode['mines']--;
                }
            }

            sort($minesCoordinateAry);

            return $minesCoordinateAry;
        }

        //Composition of array that the position user select
        public function userSelectCoordinate($userInputAry, $mode) {
            while(($userInputAry['selectCoordinateX'] > $mode['range'][0] - 1) || $userInputAry['selectCoordinateX'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputAry['selectCoordinateX'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($userInputAry['selectCoordinateY'] > $mode['range'][1] - 1) || $userInputAry['selectCoordinateY'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputAry['selectCoordinateY'] = (int)readline("Enter Coordinate Y:")-1;
            }

            $userInputAry['selectCoordinate'] = $userInputAry['selectCoordinateX'].",".$userInputAry['selectCoordinateY'];

            return $userInputAry;
        }

        //check number of mines around the position user select
        public function checkNumberOfMines ($userInputAry, $minesCoordinateAry) {
            if(in_array($userInputAry['selectCoordinate'], $minesCoordinateAry)) {
                echo "You Died"."\n";
                return;
            }

            $numberOfMines = 0;

            foreach ($minesCoordinateAry as $coordinates) {
                $coordinatesX = explode(",", $coordinates)[0];
                $coordinatesY = explode(",", $coordinates)[1];

                //calculate distance between mines and the position user select
                $squareOfDistance =
                    pow($userInputAry['selectCoordinateX'] - $coordinatesX, 2) +
                    pow($userInputAry['selectCoordinateY'] - $coordinatesY, 2);
                if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                    $numberOfMines++;
                }
            }

            return $numberOfMines;
        }

        public function safeArea($userInputAry, $minesCoordinateAry, $checkedCoordinateAry, $mode) {
            if(in_array($userInputAry['selectCoordinate'], $minesCoordinateAry)) {
                return $checkedCoordinateAry;
            }

            //The array of user select coordinate and coordinates around.
            $minusCoordinateX = max(($userInputAry['selectCoordinateX'] - 1), 0);
            $minusCoordinateY = max(($userInputAry['selectCoordinateY'] - 1), 0);
            $positionCoordinateX =
                ($userInputAry['selectCoordinateX']+1) >= ($mode['range'][0]-1) ? $mode['range'][0]-1 : ($userInputAry['selectCoordinateX']+1);
            $positionCoordinateY =
                ($userInputAry['selectCoordinateY']+1) >= ($mode['range'][1]-1) ? $mode['range'][1]-1 : ($userInputAry['selectCoordinateY']+1);

            $checkedCoordinateTempAry = array_unique([
                0 => $minusCoordinateX . "," . $minusCoordinateY,
                1 => ($userInputAry['selectCoordinateX']) . "," . $minusCoordinateY,
                2 => $positionCoordinateX . "," . $minusCoordinateY,
                3 => $minusCoordinateX . "," . ($userInputAry['selectCoordinateY']),
                4 => $userInputAry['selectCoordinate'],
                5 => $positionCoordinateX . "," . $userInputAry['selectCoordinateY'],
                6 => $minusCoordinateX . "," . $positionCoordinateY,
                7 => ($userInputAry['selectCoordinateX']) . "," . $positionCoordinateY,
                8 => $positionCoordinateX . "," . $positionCoordinateY
            ]);

            //Generate list of the array of safe coordinates.
            if(array_diff($checkedCoordinateTempAry, $minesCoordinateAry)) {
                $checkedCoordinateTempAry = array_diff($checkedCoordinateTempAry, $minesCoordinateAry);

                if(array_diff($checkedCoordinateTempAry, $checkedCoordinateAry)) {
                    $tempDiffWithChecked = array_diff($checkedCoordinateTempAry, $checkedCoordinateAry);

                    foreach($tempDiffWithChecked as $tempDiffWithCheckedCoordinate) {
                        $checkedCoordinateAry[] = $tempDiffWithCheckedCoordinate;
                    }
                }
            }

            return $checkedCoordinateAry;
        }
    }